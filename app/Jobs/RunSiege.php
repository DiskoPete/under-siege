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
            $this->updateSiegeStatus(SiegeStatus::InProgress);

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

    private function exec(): Result
    {
        $command = "siege --no-parser -i -d5 -c{$this->siege->configuration->concurrent} -t{$this->siege->configuration->duration}S -j --file={$this->filePaths['urls']} --log={$this->filePaths['logs']}";

        exec($command, $output);

        $json = array_reduce(
            $output,
            fn(string $json, string $line) => $json . $line,
            ''
        );

        return new Result(json_decode($json, true, flags: JSON_THROW_ON_ERROR));
    }

    private function writeUrlsFile(): void
    {
        $path        = "sieges/urls/{$this->siege->uuid}.txt";
        Storage::disk()->put(
            $path,
            implode("\n", $this->siege->configuration->urls)
        );

        $this->filePaths['urls'] = Storage::path($path);
    }

    private function createLogsFile(): void
    {
        $path = "sieges/logs/" . $this->siege->uuid;
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
