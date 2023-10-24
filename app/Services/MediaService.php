<?php

namespace App\Services;

use App\Models\User;
use App\Models\Activity;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function store($model, $file)
    {
        $folder = $this->get_folder($model);

        $this->delete_media($model);

        $media = "storage/" . $file->store($folder, 'public');
        
        return $model->media()->create([
            'url' => $media,
        ]);
    }

    public function delete_media($model)
    {
        if($model->media) {
            Storage::delete($model->media->url);
            $model->media()->delete();
        }
    }

    protected function get_folder($model)
    {
        if ($model instanceof Activity) {
            return 'activities';
        } elseif ($model instanceof Comment) {
            return 'comments';
        } elseif ($model instanceof User) {
            return 'users';
        }
    }


}
