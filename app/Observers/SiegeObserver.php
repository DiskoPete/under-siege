<?php

namespace App\Observers;

use App\Events\SiegeChanged;
use App\Models\Siege;

class SiegeObserver
{
    public function updated(Siege $siege): void
    {
        event(new SiegeChanged($siege));
    }
}
