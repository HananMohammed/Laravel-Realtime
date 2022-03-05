<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    /**
     * Create a new event instance.
     * Synchronize Messages Between users on realTime 
     *
     * @return void
     */
    public function __construct(User $user, $message)
    {
        $this->user = $user;

        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        Log::debug("User: { $this->user->name }, Send Message :{ $this->message }");
        return new PresenceChannel('chat');
    }
}
