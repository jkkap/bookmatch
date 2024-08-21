<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Library\ChatRoom;
//use App\Models\ChatRoom;

class MessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $chatroom;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatRoom $chatroom)
    {
        $this->chatroom = $chatroom;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chatroom'),
        ];
    }
}
