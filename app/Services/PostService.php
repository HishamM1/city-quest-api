<?php

namespace App\Services;
use App\Models\Post;

class PostService {
    public function create($activity, $text = null) {
        $post_id = $this->check_if_post_exists($activity) ? $this->check_if_post_exists($activity) : Post::create([
            'activity_id' => $activity->id,
            'text' => $text,
        ])->id;

        $activity->update([
            'public' => true,
        ]);

        return $post_id;
    }

    private function check_if_post_exists($activity) {
        if ($activity->post) {
            return $activity->post->id;
        }
        return false;
    }
}
