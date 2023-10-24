<?php

use App\Http\Controllers\Api\v1\ActivityController;
use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\v1\CompleteActivityController;
use App\Http\Controllers\Api\v1\LikeController;
use App\Http\Controllers\Api\v1\PostController;
use App\Http\Controllers\Api\v1\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::get('user', [ProfileController::class, 'show']);
    Route::post('user', [ProfileController::class, 'update']);
    Route::delete('user', [ProfileController::class, 'delete']);

    Route::apiResource('posts', PostController::class);

    Route::apiResource('activities', ActivityController::class)->except('update');
    Route::post('activities/{activity}', [ActivityController::class, 'update']);

    Route::post('like/{id}/{type}', [LikeController::class, 'like']);
    Route::delete('like/{id}/{type}', [LikeController::class, 'dislike']);

    Route::apiResource('comments', CommentController::class)->only(['store', 'destroy']);
    Route::post('comments/{comment}', [CommentController::class, 'update']);

    Route::post('complete-activity/{activity}', CompleteActivityController::class);
});

require __DIR__ . '/auth.php';
