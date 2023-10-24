<?php

namespace App\Observers;

use App\Models\Like;

class LikeObserver
{
    public function creating(Like $like): void
    {
        $like->user_id = auth('api')->id();
    }
}
