<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\CompleteActivityRequest;
use App\Http\Controllers\Controller;
use App\Services\MediaService;
use App\Services\PostService;
use App\Models\Activity;

class CompleteActivityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CompleteActivityRequest $request, Activity $activity)
    {
        $request->validated();

        $activity->update([
            'completed' => true,
            'rate' => $request->rate,
        ]);


        if ($request->hasFile('media')) {
            (new MediaService())->store($activity, $request->file('media'));
        }

        if ($request->public) {
            $post_id = (new PostService())->create($activity->load(['post']), $request->text);
        }

        return response()->json([
            'message' => 'Activity completed successfully',
            'post_id' => $post_id,
        ]);
    }
}
