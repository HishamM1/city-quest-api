<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Notifications\CommentNotification;
use App\Services\MediaService;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'comment');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $request->validated();
        
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'text' => $request->text,
        ]);

        if ($request->hasFile('media')) {
            (new MediaService())->store($comment, $request->file('media'));
        }

        // send notification to post owner
        $post = $comment->post;
        $post_owner = $post->user;
        $post_owner->notify(new CommentNotification($post->id, $post_owner->username));


        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => CommentResource::make($comment->load(['media'])),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $request->validated();

        $comment->update([
            'text' => $request->text,
        ]);

        if ($request->hasFile('media')) {
            (new MediaService())->store($comment, $request->file('media'));
        }

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $comment->load(['media'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        (new MediaService())->delete_media($comment);
        $comment->delete();
        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }
}
