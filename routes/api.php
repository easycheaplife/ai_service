<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageRecognitionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EssayController;

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

Route::post('/file/upload', [FileController::class, 'upload']);

Route::get('/file/download/{file_name}', [FileController::class, 'download']);

Route::get('/image-recognition', [ImageRecognitionController::class, 'recognize']);
Route::post('/image-recognition', [ImageRecognitionController::class, 'recognize']);

Route::get('/chat', [ChatController::class, 'chat']);
Route::post('/chat', [ChatController::class, 'chat']);

// 作文相关路由
Route::prefix('essay')->group(function () {
    $methods = ['get', 'post'];
    Route::match($methods, '/write', [EssayController::class, 'write']);
    Route::match($methods, '/template', [EssayController::class, 'template']);
    Route::match($methods, '/continue', [EssayController::class, 'continue']);
    Route::match($methods, '/correct', [EssayController::class, 'correct']);
    Route::match($methods, '/review', [EssayController::class, 'review']);
});
