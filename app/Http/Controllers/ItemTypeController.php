<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemType;
use App\Http\Resources\ItemTypeResource;
use App\Http\Requests\StoreItemTypeRequest;
use App\Http\Requests\UpdateItemTypeRequest;
use Illuminate\Auth\Access\Gate;

class ItemTypeController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('item_type_index');

      $query = ItemType::query();

      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('type', 'LIKE', "%{$search}%");
        });
      }

      if ($request->has('classification')) {
        $query->where('classification', $request->classification);
      }

      // Sorting (default to ID)
      if ($request->has('sort')) {
        $order = $request->input('order', 'asc');
        $query->orderBy($request->sort, $order);
      }

      // Paginate with customizable per-page count
      $item_types = $query->paginate($request->input('per_page', 5))->appends($request->query());

      return response()->json([
          'data' => ItemTypeResource::collection($item_types),
          'meta' => [
              'total' => $item_types->total(),
              'per_page' => $item_types->perPage(),
              'current_page' => $item_types->currentPage(),
              'last_page' => $item_types->lastPage(),
          ]
      ]);
    }

    public function store(StoreItemTypeRequest $request) {
      // Gate::authorize('item_type_store');
      
      $data = $request->validated();

      $item_type = ItemType::create($data);

      return new ItemTypeResource($item_type);
    }

    public function update(UpdateItemTypeRequest $request, ItemType $item_type) {
      // Gate::authorize('item_type_update');

      $data = $request->validated();

      $item_type->update($data);

      return new ItemTypeResource($item_type);
    }

    public function destroy(ItemType $item_type) {
      // Gate::authorize('item_type_destroy');

      $item_type->delete();
      
      return new ItemTypeResource($item_type);
    }

    public function select() {
        $item_types = ItemType::all();

        return response()->json([
          'data' => ItemTypeResource::collection($item_types)
        ]);
    }
}
