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
use App\Http\Controllers\ItServiceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryController;
use App\Http\Middleware\AuthGates;
use App\Enums\TicketStatus;

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

  Route::apiResource('inventories', InventoryController::class); 

  Route::apiResource('it-services', ItServiceController::class);

  Route::apiResource('tickets', TicketController::class);

  Route::apiResource('solutions', SolutionController::class);

  Route::apiResource('agencies', AgencyController::class);

  Route::apiResource('measurement-units', MeasurementUnitController::class);

  Route::apiResource('inventory-items', InventoryItemController::class);

  // Custom Routes

  Route::get('permissions-all', [PermissionController::class, 'permissionAll']);

  Route::get('roles-select', [RoleController::class, 'select']);

  Route::get('departments-select', [DepartmentController::class, 'select']);
  
  Route::get('positions-select', [PositionController::class, 'select']);

  Route::get('brands-select', [BrandController::class, 'select']);

  Route::get('brand-models-select', [BrandModelController::class, 'select']);

  Route::get('item-types-select', [ItemTypeController::class, 'select']);

  Route::get('it-services-select', [ItServiceController::class, 'select']);

  Route::get('solutions-select', [SolutionController::class, 'select']);

  Route::get('agencies-select', [AgencyController::class, 'select']);

  Route::get('measurement-units-select', [MeasurementUnitController::class, 'select']);

  // Ticket Actions

  Route::post('tickets/{ticket}/accept', [TicketController::class, 'accept']);
  Route::post('tickets/{ticket}/check-stock', [TicketController::class, 'checkStock']);
  Route::post('tickets/{ticket}/await-part', [TicketController::class, 'awaitPart']);
  Route::post('tickets/{ticket}/resolve', [TicketController::class, 'resolve']);
  Route::post('tickets/{ticket}/cancel', [TicketController::class, 'cancel']);
  Route::post('tickets/{ticket}/reopen', [TicketController::class, 'reopen']);
  Route::post('tickets/{ticket}/set-service-method', [TicketController::class, 'setServiceMethod']);
  Route::post('tickets/{ticket}/set-release-date', [TicketController::class, 'setReleaseDate']);
  

  // Search Routes

  Route::get('employees-search', [EmployeeController::class, 'search']);

  Route::get('items-search', [ItemController::class, 'search']);

  Route::get('agencies-search', [AgencyController::class, 'search']);

  Route::get('inventory-items-search', [InventoryItemController::class, 'search']);

  // Enums

  Route::get('/query-statuses', fn () =>
    collect(TicketStatus::cases())
      ->map(fn ($status) => [
          'value' => $status->value,
          'label' => str_replace('_', ' ', ucfirst($status->name)),
      ])
  );

});