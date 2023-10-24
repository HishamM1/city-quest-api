<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;


class ActivityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Activity::class, 'activity');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ActivityResource::collection(Activity::byUser()->with(['city', 'category', 'media'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request)
    {
        $activity = Activity::create($request->validated());

        return response()->json([
            'message' => 'Activity created successfully',
            'activity' => ActivityResource::make($activity->load(['city', 'category']))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return ActivityResource::make($activity->load(['city', 'category', 'media']));

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());

        return response()->json([
            'message' => 'Activity updated successfully',
            'activity' => ActivityResource::make($activity->load(['city', 'category', 'media']))
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return response()->json([
            'message' => 'Activity deleted successfully'
        ]);
    }
}
