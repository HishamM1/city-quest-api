<?php

namespace App\Observers;

use App\Models\Comment;
use App\Services\MediaService;

class CommentObserver
{
    public function creating(Comment $comment): void
    {
        $comment->user_id = auth('api')->id();
    }

    public function deleting(Comment $comment): void
    {
        (new MediaService())->delete_media($comment);
    }
}
