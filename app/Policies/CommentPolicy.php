<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can create a model.
     */
    public function create(User $user): Response
    {
        return $user->id ? Response::allow() : Response::deny('You need to be logged in');
    }
    
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id ? Response::allow() : Response::deny('Not your comment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id ? Response::allow() : Response::deny('Not your comment');
    }
}
