<?php

namespace App\Observers;

use App\Events\SiegeChanged;
use App\Models\Siege;
use App\Support\SiegeSession;

class SiegeObserver
{
    public function __construct(
        private readonly SiegeSession $siegeSession
    )
    {
    }

    public function created(Siege $siege): void
    {
        $this->siegeSession->addSiege($siege);
    }

    public function updated(Siege $siege): void
    {
        event(new SiegeChanged($siege));
    }
}
