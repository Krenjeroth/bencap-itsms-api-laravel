<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('permission_index');

      $query = Role::query();

      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('title', 'LIKE', "%{$search}%");
        });
      }

      // Sorting (default to ID)
      if ($request->has('sort')) {
        $order = $request->input('order', 'asc');
        $query->orderBy($request->sort, $order);
      }

      // Paginate with customizable per-page count
      $roles = $query->paginate($request->input('per_page', 5))->appends($request->query());

      return response()->json([
          'data' => RoleResource::collection($roles),
          'meta' => [
              'total' => $roles->total(),
              'per_page' => $roles->perPage(),
              'current_page' => $roles->currentPage(),
              'last_page' => $roles->lastPage(),
          ]
      ]);
    }

    public function store(StoreRoleRequest $request) {
      // Gate::authorize('permission_store');
      
      $data = $request->validated();

      $role = Role::create($data);

      return new RoleResource($role);
    }

    public function update(UpdateRoleRequest $request, Role $role) {
      // Gate::authorize('permission_update');

      $data = $request->validated();

      $role->update($data);

      return new RoleResource($role);
    }

    public function destroy(Role $role) {
      // Gate::authorize('permission_destroy');

      $role->delete();
      
      return new RoleResource($role);
    }
}
