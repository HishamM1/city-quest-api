<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\LikeService;
use App\Enums\Type;

class LikeController extends Controller
{
    public function like(string $id, Type $type, LikeService $likeService)
    {
        if (!$likeService->check_type($type->value)) {
            return response()->json([
                'message' => 'Invalid type',
            ], 422);
        }

        $success = $likeService->like($type->value, $id);

        if(!$success) {
            return response()->json([
                'message' => 'Invalid id',
            ], 422);
        }

        return response()->json([
            'message' => 'Liked successfully',
        ],200);
    }

    public function dislike(string $id, Type $type, LikeService $likeService)
    {
        if (!$likeService->check_type($type->value)) {
            return response()->json([
                'message' => 'Invalid type',
                'code' => 422,
            ], 422);
        }

        $success = $likeService->dislike($type->value, $id);

        if(!$success) {
            return response()->json([
                'message' => 'Invalid id',
                'code' => 422,
            ], 422);
        }
        
        return response()->json([
            'message' => 'Disliked successfully',
        ],200);
    }
}
