<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Test implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public array $order = ["oi"];
    public string $queue = 'default';
    public string $connection = 'database';
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(bool $central = false)
    {
        if ($central) {
            $this->connection = 'central';
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $tenantId = null;
        if (tenant()) {
            $tenantId = tenant()->id;
        }
        return [ new PrivateChannel('test2.' . 1), new PrivateChannel('test.' . 1), new PrivateChannel('test3.' . $tenantId)];
    }
}
