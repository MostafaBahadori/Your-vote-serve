<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;

// auth
Route::post('/signup', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);


// protected routes
Route::group(['middleware'=>['auth:sanctum']],  function () {
    
    Route::get('/user', [UserController::class, 'show']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);
    Route::get('/user/search/{query}', [UserController::class, 'search']);

    Route::post('/manager', [ManagerController::class, 'create']);
    Route::get('/manager', [ManagerController::class, 'index']);
    Route::get('/manager/request', [ManagerController::class, 'request']);
    Route::get('/manager/search/{query}', [ManagerController::class, 'search']);
    
    Route::get('election/search', [ElectionController::class, 'search']);
    Route::resource('election', ElectionController::class);
    
    Route::get('candidate', [CandidateController::class, 'show']);
    Route::delete('candidate', [CandidateController::class, 'destroy']);
    Route::resource('candidate', CandidateController::class)->only(['store']);

    

    Route::resource('request', RequestController::class);
    Route::post('/request/{requestModel}/answer/', [RequestController::class, 'answer']);
    

    Route::post('/vote', [VoteController::class, 'store']);
    
    
});

