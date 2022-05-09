<?php

namespace App\Observers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class CrawlObserver extends \Spatie\Crawler\CrawlObservers\CrawlObserver
{
    public bool $finished = false;

    public function __construct(
        public readonly Collection $urls = new Collection()
    )
    {
    }


    /**
     * @inheritDoc
     */
    public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null): void
    {
        $this->urls->push((string) $url);
    }

    /**
     * @inheritDoc
     */
    public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null): void
    {

    }

    public function finishedCrawling(): void
    {
        $this->finished = true;
    }
}
