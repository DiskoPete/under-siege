<?php

namespace App\Http\Livewire;

use App\Events\SiegeChanged;
use App\Models\Siege;
use Livewire\Component;

class SiegeDetails extends Component
{

    public Siege $siege;

    public int $timeLeft = 0;


    public function mount(): void
    {
        $this->calcTimeLeft();
    }


    protected function getListeners()
    {
        return [
            "echo:siege-{$this->siege->uuid},." . SiegeChanged::class => 'reloadSiege'
        ];
    }


    public function reloadSiege(): void
    {
        $this->siege->refresh();
        $this->calcTimeLeft();
    }


    public function render()
    {
        return view('livewire.siege-details');
    }

    private function calcTimeLeft(): void
    {
        if (!$this->siege->started_at) {
            return;
        }

        $endsAt = $this->siege->started_at->addSeconds($this->siege->configuration->duration);

        if ($endsAt < now()) {
            return;
        }

        $this->timeLeft = $endsAt->diffInSeconds(now());
    }
}
