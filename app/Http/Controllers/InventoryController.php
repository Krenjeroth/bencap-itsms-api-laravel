<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Resources\InventoryResource;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('item_type_index');

      $query = Inventory::query();

      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('property_number', 'LIKE', "%{$search}%")
          ->orWhere('parent_component', 'LIKE', "%{$search}%")
          ->orWhere('serial_number', 'LIKE', "%{$search}%")
          ->orWhere('description', 'LIKE', "%{$search}%");
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
      $items = $query->paginate($request->input('per_page', 5))->appends($request->query());

      return response()->json([
          'data' => InventoryResource::collection($items),
          'meta' => [
              'total' => $items->total(),
              'per_page' => $items->perPage(),
              'current_page' => $items->currentPage(),
              'last_page' => $items->lastPage(),
          ]
      ]);
    }

    public function store(StoreInventoryRequest $request) {
      // Gate::authorize('item_store');
      
      $data = $request->validated();

      $item = Inventory::create($data);

      return new InventoryResource($item);
    }

    public function update(UpdateInventoryRequest $request, Inventory $inventory) {
      // Gate::authorize('item_update');

      $data = $request->validated();

      $inventory->update($data);

      return new InventoryResource($inventory);
    }

    public function destroy(Inventory $inventory) {
      // Gate::authorize('item_destroy');

      $inventory->delete();
      
      return new InventoryResource($inventory);
    }

    public function search(Request $request) {
      $query = $request->get('q');
      $limit = (int) $request->get('limit', 20);
      $page = (int) $request->get('page', 1);
      $offset = ($page - 1) * $limit;

      $items = Inventory::query()
          ->when($query, fn($qBuilder) =>
              $qBuilder->where('property_number', 'like', "%$query%")
          )
          ->offset($offset)
          ->limit($limit)
          ->get();

      return response()->json([
          'data' => InventoryResource::collection($items),
      ]);
    }
}
