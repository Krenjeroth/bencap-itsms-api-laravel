<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\InventoryResource;
use App\Models\InventoryInternalComponent;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;

class InventoryController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('item_type_index');

      $query = Inventory::query();

      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('property_number', 'LIKE', "%{$search}%")
          // ->orWhere('parent_component', 'LIKE', "%{$search}%")
          ->orWhere('serial_number', 'LIKE', "%{$search}%");
          // ->orWhere('description', 'LIKE', "%{$search}%");
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
      $inventories = $query->paginate($request->input('per_page', 5))->appends($request->query());

      return response()->json([
          'data' => InventoryResource::collection($inventories),
          'meta' => [
              'total' => $inventories->total(),
              'per_page' => $inventories->perPage(),
              'current_page' => $inventories->currentPage(),
              'last_page' => $inventories->lastPage(),
          ]
      ]);
    }

    public function store(StoreInventoryRequest $request) {
      // Gate::authorize('item_store');
      
      $data = $request->validated();
      
      $inventory = Inventory::create($data);
      
      if ((int) $data['item_type_id'] === 1) {
        foreach ($data['internal_components'] ?? [] as $component) {
          InventoryInternalComponent::create([
              'inventory_id'   => $inventory->id,
              'brand_model_id' => $component['brand_model']['id'],
              'quantity'       => $component['quantity'],
          ]);
        }
      }

      return new InventoryResource($inventory);
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

      $inventories = Inventory::query()
          ->when($query, fn($qBuilder) =>
              $qBuilder->where('property_number', 'like', "%$query%")
          )
          ->offset($offset)
          ->limit($limit)
          ->get();

      return response()->json([
          'data' => InventoryResource::collection($inventories),
      ]);
    }

    public function searchMainAsset(Request $request) {
      $query = $request->get('q');
      $limit = (int) $request->get('limit', 20);
      $page = (int) $request->get('page', 1);
      $offset = ($page - 1) * $limit;

      $inventories = Inventory::query()
          ->when($query, fn($qBuilder) =>
              $qBuilder->where('item_type.is_main_asset', true)->where('item_type.is_component', false)->where('property_number', 'like', "%$query%")
              // ->orWhere('stock_number', 'like', "%$query%")
              // ->orWhere('description', 'like', "%$query%")
              // ->orWhereHas('brand_model', function ($q2) use($query) {
              //   $q2->where('name', 'like', "%$query%")
              //   ->orWhereHas('brand', function ($q3) use($query) {
              //     $q3->where('name', 'like', "%$query%");
              //   })
              //   ->orWhereHas('item_type', function ($q4) use($query) {
              //     $q4->where('type', 'like', "%$query%");
              //   });
              // })
          )
          ->offset($offset)
          ->limit($limit)
          ->get();

      return response()->json([
          'data' => InventoryResource::collection($inventories),
      ]);
    }
}
