<?php

namespace App\Jobs;

use App\Enums\SiegeStatus;
use App\Models\Siege;
use App\Support\Siege\Result;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class RunSiege implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;
    public $tries = 3;

    private array $filePaths = [
        'urls' => null,
        'logs' => null
    ];

    public function __construct(
        private readonly Siege $siege
    )
    {
        //
    }


    public function handle()
    {

        try {
            $this->siege->started_at = now();
            $this->siege->status = SiegeStatus::InProgress;
            $this->siege->save();

            $this->writeUrlsFile();
            $this->createLogsFile();

            $this->siege->results = $this->exec();
            $this->siege->status  = SiegeStatus::Complete;
            $this->siege->save();
        } catch (Throwable $e) {
            Log::critical($e);
            $this->updateSiegeStatus(SiegeStatus::Failed);
        } finally {
            $this->cleanupFiles();
        }
    }

    private function updateSiegeStatus(SiegeStatus $status): void
    {
        $this->siege->status = $status;
        $this->siege->save();
    }

    private function makeHeadersOption(): string|null
    {
        $headers = $this->siege->configuration->headers;

        if (!$headers) {
            return null;
        }

        return sprintf(
            '--header="%s"',
            collect($headers)
                ->map(fn(string $value, string $name) => "$name: $value")
                ->join(',')
        );
    }

    private function exec(): Result
    {
        $headers = $this->makeHeadersOption();
        $command = "siege --no-parser -ij -d5 -c{$this->siege->configuration->concurrent} -t{$this->siege->configuration->duration}S --file={$this->filePaths['urls']} --log={$this->filePaths['logs']} $headers";

        exec($command, $output);

        $json = array_reduce(
            $output,
            fn(string $json, string $line) => $json . $line,
            ''
        );

        try {
            $attributes = json_decode($json, true, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException("Could not parse json: $json", previous: $e);
        }
        return new Result($attributes);
    }

    private function writeUrlsFile(): void
    {
        $path = "sieges/urls/{$this->siege->uuid}.txt";

        $urls = $this->siege->configuration->urls ?: [$this->siege->configuration->target];

        Storage::disk()->put(
            $path,
            implode("\n", $urls)
        );

        $this->filePaths['urls'] = Storage::path($path);
    }

    private function createLogsFile(): void
    {
        $path                    = "sieges/logs/" . $this->siege->uuid;
        $this->filePaths['logs'] = Storage::path($path);

    }

    private function cleanupFiles(): void
    {
        foreach ($this->filePaths as $filePath) {
            if (!$filePath || !is_readable($filePath)) {
                continue;
            }

            unlink($filePath);
        }
    }
}
