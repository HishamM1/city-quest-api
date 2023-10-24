<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Observers\ActivityObserver;
use App\Observers\CommentObserver;
use App\Observers\PostObserver;
use App\Observers\LikeObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'User' => 'App\Models\User',
            'Post' => 'App\Models\Post',
            'Activity' => 'App\Models\Activity',
            'Comment' => 'App\Models\Comment',
        ]);

        JsonResource::withoutWrapping();

        Post::observe(PostObserver::class);
        Activity::observe(ActivityObserver::class);
        Comment::observe(CommentObserver::class);
        Like::observe(LikeObserver::class);
    }
}
