<?php

namespace App\Events;

use App\Models\Post\Post;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(public Post $post)
    {
        //
    }


    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('Post Event'),
        ];
    }
}
