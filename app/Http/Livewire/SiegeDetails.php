<?php

namespace App\Http\Livewire;

use App\Events\SiegeChanged;
use App\Models\Siege;
use Livewire\Component;

class SiegeDetails extends Component
{

    public Siege $siege;


    protected function getListeners()
    {
        return [
            "echo:siege-{$this->siege->uuid},." . SiegeChanged::class => 'reloadSiege'
        ];
    }

    public function reloadSiege(): void
    {
        $this->siege->refresh();
    }


    public function render()
    {
        return view('livewire.siege-details');
    }
}
