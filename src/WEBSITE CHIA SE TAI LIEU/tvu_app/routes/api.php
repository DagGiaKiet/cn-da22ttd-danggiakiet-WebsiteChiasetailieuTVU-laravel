<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Messages API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/messages/unread-count', [App\Http\Controllers\MessageController::class, 'unreadCount']);
    Route::get('/messages/conversations', [App\Http\Controllers\MessageController::class, 'conversations']);
    Route::post('/messages/send', [App\Http\Controllers\MessageController::class, 'send']);
    Route::post('/messages/mark-as-read', [App\Http\Controllers\MessageController::class, 'markAsRead']);
});
