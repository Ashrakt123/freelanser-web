<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Messages implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

     public $message;
     public $sender_id;
     public $reciever_id;
     public $username;
    public function __construct($message , $sender_id , $reciever_id , $username)
    {
        $this->message = $message;
        $this->reciever_id = $reciever_id;
        $this->sender_id = $sender_id;
        $this->username = $username;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('chat' . $this->reciever_id);
        
        return new Channel('chat');
    }

    public function broadcastAs(){
        return 'message';
    }
}
