<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthGates;

Route::group(['middleware' => ['auth:sanctum', AuthGates::class]], function () {
  Route::get('user', function (Request $request) {
    return UserResource::make($request->user());
  });

  Route::apiResource('users', UserController::class);
});