<?php

use App\Http\Controllers\Api\v1\ImageController;
use App\Http\Controllers\Api\v1\PostController;
use App\Http\Controllers\Api\v1\UserController;
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


Route::middleware(['localization'])->group(function() {

Route::controller(UserController::class)->prefix('user')->group(function (){
    Route::post('/store','store');
    Route::get('/show/{id}','show');
    Route::get('/all','all');
    Route::post('/edit','edit');
});


Route::controller(PostController::class)->prefix('post')->group(function (){
    Route::post('/store','store');
    Route::get('/show/{id}','show');
    Route::get('/all','all');
    Route::post('/edit','edit');
});

Route::controller(ImageController::class)->prefix('image')->group(function (){
    Route::get('/all','all');
    Route::post('/edit','edit');
});

});
