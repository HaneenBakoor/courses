<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MyBroadcastEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message="sucess";
    public $course,$user;

    public function __construct($data)
    {
        $this->user = $data['user'];
        $this->course = $data['course'];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('my-channel')
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'user' => $this->user,
            'course' => $this->course
        ];
    }

    /**
     * The event's broadcast name.
     * This makes the event name 'MyBroadcastEvent' instead of 'App.Events.MyBroadcastEvent'
     * on the client side.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'MyBroadcastEvent';
    }
}
