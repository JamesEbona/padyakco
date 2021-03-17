<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MechanicUnassignEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking;
    public $mechanic_number;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($booking,$mechanic_number)
    {
        $this->booking = $booking;
        $this->mechanic_number = $mechanic_number;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
