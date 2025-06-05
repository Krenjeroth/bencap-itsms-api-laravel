<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BrandModelController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\CommonProblemController;
use App\Http\Controllers\ItemController;
use App\Http\Middleware\AuthGates;

Route::group(['middleware' => ['auth:sanctum', AuthGates::class]], function () {
  Route::get('user', function (Request $request) {
    return UserResource::make($request->user());
  });

  Route::apiResource('users', UserController::class);

  Route::apiResource('departments', DepartmentController::class);

  Route::apiResource('permissions', PermissionController::class);

  Route::apiResource('roles', RoleController::class);

  Route::apiResource('positions', PositionController::class);

  Route::apiResource('employees', EmployeeController::class);

  Route::apiResource('brands', BrandController::class);

  Route::apiResource('brand-models', BrandModelController::class);

  Route::apiResource('item-types', ItemTypeController::class);

  Route::apiResource('common-problems', CommonProblemController::class);

  Route::apiResource('items', ItemController::class); 

  // Custom Routes

  Route::get('permissions-all', [PermissionController::class, 'permissionAll']);

  Route::get('roles-select', [RoleController::class, 'select']);

  Route::get('departments-select', [DepartmentController::class, 'select']);
  
  Route::get('positions-select', [PositionController::class, 'select']);

  Route::get('brands-select', [BrandController::class, 'select']);

  Route::get('brand-models-select', [BrandModelController::class, 'select']);

  Route::get('item-types-select', [ItemTypeController::class, 'select']);

});