<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Activity;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with([
            'user:id,name,username',
            'user.media',
            'comments.media',
            'comments.user:id,name,username',
            'comments.user.media',
            'comments.likes.user:id,name,username',
            'comments.likes.user.media',
            'likes.user:id,name,username',
            'likes.user.media',
            'activity.media'
        ])->get();

        return PostResource::collection($posts);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return PostResource::make($post->load([
            'user:id,name,username',
            'user.media',
            'comments.media',
            'comments.user:id,name,username',
            'comments.user.media',
            'comments.likes.user:id,name,username',
            'comments.likes.user.media',
            'likes.user:id,name,username',
            'likes.user.media',
            'activity.media'
        ]));
    }

    public function store(StorePostRequest $request)
    {
        $request->validated();

        $activity = Activity::select('id', 'completed', 'public')->findOrFail($request->activity_id);

        if (!$activity->completed) {
            return response()->json([
                'message' => 'Activity not completed',
            ], 422);
        }

        $post_id = (new PostService())->create($activity->load(['post']), $request->text);

        return response()->json([
            'message' => 'Post created successfully',
            'post_endpoint' => $post_id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validated();

        $post->update($request->all());

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => PostResource::make($post->load([
                'user:id,name,username',
                'user.media',
                'comments.media',
                'comments.user:id,name,username',
                'comments.user.media',
                'comments.likes.user:id,name,username',
                'comments.likes.user.media',
                'likes.user:id,name,username',
                'likes.user.media',
                'activity.media'
            ]))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}
