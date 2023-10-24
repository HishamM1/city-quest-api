<?php

namespace App\Services;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\LikeNotification;

class LikeService
{
    public $types = [
        'posts',
        'comments',
    ];

    public function like($type, $id)
    {
        $model = $this->get_model($type, $id);

        if(!$model) {
            return false;
        }

        $like = $this->check_like_exists($model);

        if(!$like) {
            $model->likes()->create();
            $this->send_notification($model->id, $type);
        }

        return true;
    }

    public function dislike($type, $id)
    {
        $model = $this->get_model($type, $id);

        if(!$model) {
            return false;
        }

        $like = $this->check_like_exists($model);

        if($like) {
            $like->delete();
        }

        return true;
    }

    private function get_model($type, $id)
    {
        if ($type == 'posts') {
            return Post::find($id);
        } elseif ($type == 'comments') {
            return Comment::find($id);
        } else {
            return null;
        }
    }

    public function check_type($type)
    {
        return in_array($type, $this->types);
    }

    private function check_like_exists($model)
    {
        return $model->likes()->where('user_id', auth('api')->id())->first();
    }

    private function send_notification($model, $type)
    {
        $model->user->notify(new LikeNotification($model, $type));
    }
    
}
