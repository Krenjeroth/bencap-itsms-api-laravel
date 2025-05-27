<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index(Request $request) {
      Gate::authorize('user_index');

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

    public function store(StoreUserRequest $request) {
      Gate::authorize('user_store');
      
      $data = $request->validated();

      $user = User::create($data);

      return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user) {
      // Gate::authorize('user_update');

      $data = $request->validated();

      $user->update($data);

      return new UserResource($user);
    }

    public function destroy(User $user) {
      // Gate::authorize('user_destroy');

      $storage_public = Storage::disk('public');
      if ($user->img_path && $storage_public->exists($user->img_path)) {
        $storage_public->delete($user->img_path);
      }

      $user->delete();
      
      return new UserResource($user);
    }
}
