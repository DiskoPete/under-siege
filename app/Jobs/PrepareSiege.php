<?php

namespace App\Jobs;

use App\Enums\SiegeStatus;
use App\Models\Siege;
use App\Observers\CrawlObserver;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use Spatie\Crawler\CrawlQueues\ArrayCrawlQueue;

class PrepareSiege implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 60;
    public $deleteWhenMissingModels = true;
    public $tries = 3;


    public function __construct(
        private readonly Siege $siege
    )
    {
        //
    }

    private function makeCrawlObserver(): CrawlObserver
    {
        return app(CrawlObserver::class);
    }

    public function handle()
    {

        if (!$this->siege->configuration->crawl) {
            return;
        }

        $this->markSiegeAsPreparing();

        $observer        = $this->makeCrawlObserver();
        $crawlQueue      = new ArrayCrawlQueue();
        $deadline        = now()->addSeconds($this->timeout - 10);
        $totalCrawlLimit = 100;

        do {
            Crawler::create([
                RequestOptions::ALLOW_REDIRECTS => true,
                RequestOptions::HEADERS         => [
                    'User-Agent' => config('siege.user_agent'),
                    ...$this->siege->configuration->headers ?? []
                ],
            ])
                ->setCrawlQueue($crawlQueue)
                ->setCrawlObserver($observer)
                ->setTotalCrawlLimit($totalCrawlLimit)
                ->setCurrentCrawlLimit(15)
                ->setCrawlProfile(new CrawlInternalUrls($this->siege->configuration->target))
                ->startCrawling($crawlQueue->getPendingUrl()?->url ?: $this->siege->configuration->target);
        } while (now() < $deadline && $crawlQueue->hasPendingUrls());

        $this->saveCrawledUrls($observer);

    }

    private function markSiegeAsPreparing(): void
    {
        $this->siege->status = SiegeStatus::Preparing;
        $this->siege->save();
    }

    private function saveCrawledUrls(CrawlObserver $observer): void
    {
        $this->siege->configuration->urls = $observer->urls;
        $this->siege->save();
    }
}
