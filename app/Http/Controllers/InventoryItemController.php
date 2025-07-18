<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Http\Resources\InventoryItemResource;
use App\Http\Requests\StoreInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;

class InventoryItemController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('item_type_index');

      $query = InventoryItem::query();

      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('item_number', 'LIKE', "%{$search}%")
          ->orWhere('stock_number', 'LIKE', "%{$search}%")
          ->orWhere('description', 'LIKE', "%{$search}%")
          ->orWhereHas('brand_model', function ($q2) use($search) {
            $q2->where('name', 'LIKE', "%{$search}%")
            ->orWhereHas('brand', function ($q3) use($search) {
              $q3->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('item_type', function ($q4) use($search) {
              $q4->where('type', 'LIKE', "%{$search}%");
            });
          });
        });
      }

      // Sorting (default to ID)
      if ($request->has('sort')) {
        $order = $request->input('order', 'asc');
        $query->orderBy($request->sort, $order);
      }

      // Paginate with customizable per-page count
      $items = $query->paginate($request->input('per_page', 5))->appends($request->query());

      return response()->json([
          'data' => InventoryItemResource::collection($items),
          'meta' => [
              'total' => $items->total(),
              'per_page' => $items->perPage(),
              'current_page' => $items->currentPage(),
              'last_page' => $items->lastPage(),
          ]
      ]);
    }

    public function store(StoreInventoryItemRequest $request) {
      // Gate::authorize('item_store');
      
      $data = $request->validated();

      $inventoryItem = InventoryItem::create($data);

      return new InventoryItemResource($inventoryItem);
    }

    public function update(UpdateInventoryItemRequest $request, InventoryItem $inventoryItem) {
      // Gate::authorize('item_update');

      $data = $request->validated();

      $inventoryItem->update($data);

      return new InventoryItemResource($inventoryItem);
    }

    public function destroy(InventoryItem $inventoryItem) {
      // Gate::authorize('item_destroy');

      $inventoryItem->delete();
      
      return new InventoryItemResource($inventoryItem);
    }

    public function select() {
        $inventoryItems = InventoryItem::all();

        return response()->json([
          'data' => InventoryItemResource::collection($inventoryItems)
        ]);
    }
}
