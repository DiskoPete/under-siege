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
use Throwable;

class RunSiege implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;
    public $tries = 3;

    public $timeout = 70; // TODO - Sync with max duration setting

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
            $this->siege->results = $this->exec();
            $this->siege->status  = SiegeStatus::Complete;
            $this->siege->save();
        } catch (Throwable $e) {

            Log::critical($e);
            $this->updateSiegeStatus(SiegeStatus::Failed);
        }
    }

    private function updateSiegeStatus(SiegeStatus $status): void
    {
        $this->siege->status = $status;
        $this->siege->save();
    }

    private function exec(): Result
    {
        exec("siege -d4 -c{$this->siege->configuration->concurrent} -t{$this->siege->configuration->duration}S -j " . $this->siege->configuration->target, $output);

        $json = array_reduce(
            $output,
            fn(string $json, string $line) => $json . $line,
            ''
        );

        return new Result(json_decode($json, true, flags: JSON_THROW_ON_ERROR));
    }
}
