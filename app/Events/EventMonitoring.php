<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventMonitoring
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }
    public function broadcastOn()
    {
        return ['los-monitoring'];
    } 
    public function broadcastAs()
    {
        return 'los-event';
    }
}
