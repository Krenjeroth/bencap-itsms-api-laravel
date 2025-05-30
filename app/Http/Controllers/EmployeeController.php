<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\StoreEmployeeRequest;

class EmployeeController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('employee_index');

      $query = Employee::query();

      // Search by name or email
      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('uid', 'LIKE', "%{$search}%")
          ->orWhere('firstname', 'LIKE', "%{$search}%")
          ->orWhere('lastname', 'LIKE', "%{$search}%");
        });
      }

       // Status filter (active/inactive)
      if ($request->has('status')) {
        $query->where('status', $request->status);
      }

      // Sorting (default to ID)
      if ($request->has('sort')) {
        $order = $request->input('order', 'asc');
        $query->orderBy($request->sort, $order);
      }

      // Paginate with customizable per-page count
      $employees = $query->paginate($request->input('per_page', 5))->appends($request->query());

      return response()->json([
          'data' => EmployeeResource::collection($employees),
          'meta' => [
              'total' => $employees->total(),
              'per_page' => $employees->perPage(),
              'current_page' => $employees->currentPage(),
              'last_page' => $employees->lastPage(),
          ]
      ]);
    }

    public function store(StoreEmployeeRequest $request) {
      // Gate::authorize('employee_store');
      
      $data = $request->validated();

      $employee = Employee::create($data);

      return new EmployeeResource($employee);
    }
}
