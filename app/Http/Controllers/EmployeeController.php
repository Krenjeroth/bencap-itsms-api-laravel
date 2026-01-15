<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Services\HrisClientService;
use Illuminate\Support\Facades\Cache;

class EmployeeController extends Controller
{
    public function index(Request $request, HrisClientService $hris) {
      // Gate::authorize('employee_index');

      $rows = Cache::remember('hris_employees', now()->addMinutes(2), fn () => $hris->getEmployees());
      $employees = collect($rows);

      // SEARCH (searches id/fname/lname/office/position)
      if ($request->filled('search')) {
          $search = mb_strtolower($request->input('search'));

          $employees = $employees->filter(function ($e) use ($search) {
              $haystack = mb_strtolower(implode(' ', array_filter([
                  $e['employee_id_number'] ?? '',
                  $e['fname'] ?? '',
                  $e['mname'] ?? '',
                  $e['lname'] ?? '',
                  $e['office_desc'] ?? '',
                  $e['position_title'] ?? '',
                  $e['employee_type'] ?? '',
              ])));

              return str_contains($haystack, $search);
          })->values();
      }

      // STATUS FILTER
      // HRIS sample has no status field, so this would do nothing meaningful.
      // You can either ignore it or return empty if they request status.
      if ($request->filled('status')) {
          // Option: ignore for now
          // (or if HRIS later adds a status field, filter here)
      }

      // SORTING
      // Your frontend likely sends sort keys like uid/firstname/lastname...
      // Map those to HRIS keys.
      $sort = $request->input('sort');
      if ($sort) {
          $order = strtolower($request->input('order', 'asc')) === 'desc' ? 'desc' : 'asc';

          $sortKeyMap = [
            'fullname' => 'fullname',
            'fname' => 'fname',
            'mname' => 'mname',
            'lname' => 'lname',
            'office_desc' => 'office_desc',
            'office_code' => 'office_code',
            'position_title' => 'position_title',
            'type' => 'type',
            'salary_grade_id' => 'salary_grade_id',
            'grade' => 'grade',
            'division' => 'division',
            'unit' => 'unit',
            'salary' => 'salary',

            // aliases if your UI sends these
            'firstname' => 'fname',
            'lastname' => 'lname',
          ];

          $hrisKey = $sortKeyMap[$sort] ?? $sort;

          $employees = $employees->sortBy(
              fn ($e) => $e[$hrisKey] ?? null,
              SORT_REGULAR,
              $order === 'desc'
          )->values();
      }

      // PAGINATION
      $perPage = (int) $request->input('per_page', 5);
      $page = (int) $request->input('page', 1);
      $total = $employees->count();

      $items = $employees->slice(($page - 1) * $perPage, $perPage)->values();

      $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
          $items,
          $total,
          $perPage,
          $page,
          ['path' => $request->url(), 'query' => $request->query()]
      );

      return response()->json([
          'data' => EmployeeResource::collection($paginator->getCollection()),
          'meta' => [
              'total' => $paginator->total(),
              'per_page' => $paginator->perPage(),
              'current_page' => $paginator->currentPage(),
              'last_page' => $paginator->lastPage(),
          ],
      ]);
    }

    public function store(StoreEmployeeRequest $request) {
      // Gate::authorize('employee_store');
      
      $data = $request->validated();

      $employee = Employee::create($data);

      return new EmployeeResource($employee);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee) {
      // Gate::authorize('employee_update');

      $data = $request->validated();

      $employee->update($data);

      return new EmployeeResource($employee);
    }

    public function destroy(Employee $employee) {
      // Gate::authorize('employee_destroy');

      $employee->delete();
      
      return new EmployeeResource($employee);
    }

    public function search(Request $request) {
      $query = $request->get('q');
      $limit = (int) $request->get('limit', 20);
      $page = (int) $request->get('page', 1);
      $offset = ($page - 1) * $limit;

      $employees = Employee::query()
          ->when($query, fn($qBuilder) =>
              $qBuilder->where('full_name', 'like', "%$query%")
          )
          ->offset($offset)
          ->limit($limit)
          ->get();

      return response()->json([
          'data' => EmployeeResource::collection($employees),
      ]);
    }

    public function getTest() {

    }
}
