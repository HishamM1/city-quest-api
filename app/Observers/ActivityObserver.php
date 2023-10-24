<?php

namespace App\Observers;

use App\Services\MediaService;
use App\Models\Activity;

class ActivityObserver
{
    public function creating(Activity $activity): void
    {
        $activity->user_id = auth('api')->id();
    }
    public function deleting(Activity $activity): void
    {
        (new MediaService())->delete_media($activity);
    }
}
