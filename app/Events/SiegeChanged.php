<?php

namespace App\Events;

use App\Models\Siege;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SiegeChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        private readonly Siege $siege
    )
    {
        //
    }

    public function broadcastOn()
    {
        return new Channel('siege-' . $this->siege->uuid);
    }
}
