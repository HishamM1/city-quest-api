<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    public function creating(Post $post): void
    {
        $post->user_id = auth('api')->id();
    }
    
    public function deleting(Post $post): void
    {
        $post->activity()->update([
            'public' => false,
        ]);
    }
}
