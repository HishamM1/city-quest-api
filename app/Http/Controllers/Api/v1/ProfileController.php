<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\MediaService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request) {
        return UserResource::make($request->user('api')->load(['media', 'country', 'city', 'likes']));

    }
    public function update(UpdateProfileRequest $request) {
        $user = $request->user('api');

        $user->update($request->validated());

        if ($request->hasFile('media')) {
            (new MediaService())->store($user, $request->file('media'));
        }

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => UserResource::make($user->load(['media', 'country', 'city'])),
        ]);
    }

    public function delete(Request $request) {
        $user = $request->user('api');
        if($user->media) {
            (new MediaService())->delete_media($user);
        }
        $user->delete();

        return response()->json([
            'message' => 'Profile deleted successfully',
        ]);
    }
}
