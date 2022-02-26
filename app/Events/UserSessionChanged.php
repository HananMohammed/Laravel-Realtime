<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserSessionChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public $message;
     public $type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $type )
    {
        $this->message=$message;
        $this->type=$type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        Log::debug($this->message);
        Log::debug($this->type);
        // return new Channel('notifications');
        /*
        (private channel : ) requires authenticated user to work with,
         need to specify how to determine if user has access to the channel
        */
        return new PrivateChannel('notifications');
    }
}
