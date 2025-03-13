<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('user_index');

      $query = User::query();

      // Search by name or email
      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('name', 'LIKE', "%{$search}%")
          ->orWhere('email', 'LIKE', "%{$search}%");
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
      $users = $query->paginate($request->input('per_page', 5))->appends($request->query());

      return response()->json([
          'data' => UserResource::collection($users),
          'meta' => [
              'total' => $users->total(),
              'per_page' => $users->perPage(),
              'current_page' => $users->currentPage(),
              'last_page' => $users->lastPage(),
          ]
      ]);
    }
}
