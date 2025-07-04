<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login']);

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::delete('/users/logout', [AuthController::class, 'logout']);
    Route::get('/users/current', [AuthController::class, 'getUsers']);
    Route::get('/users/{id}', [AuthController::class, 'getUserById']);
    Route::put('/users/{id}', [AuthController::class, 'updateUser']);
    Route::delete('/users/{id}', [AuthController::class, 'deleteUser']);

    Route::get('/items',[ItemController::class, 'getItems']);
    Route::get('/items/{id}',[ItemController::class, 'getItemDetails']);
    Route::delete('/items/{id}',[ItemController::class, 'deleteItem']);
});