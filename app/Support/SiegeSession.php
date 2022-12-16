<?php

namespace App\Support;

use App\Models\Siege;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class SiegeSession
{
    const SESSION_KEY_SIEGES = 'sieges';

    public function addSiege(Siege $siege): self
    {
        Session::push(self::SESSION_KEY_SIEGES, $siege);

        return $this;
    }

    /**
     * @return Collection<int,Siege>
     */
    public function getSieges(): Collection
    {
        return collect(Session::get(self::SESSION_KEY_SIEGES));
    }
}
