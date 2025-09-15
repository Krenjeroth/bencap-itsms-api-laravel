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

      // might only show System Unit Components / Parent components
      // Child components will be shown in the parent component expandable details.
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

      // 2. Handle internal components if item_type_id = 1
      if ((int) $data['item_type_id'] === 1) {
        $newComponents = $data['internal_components'] ?? [];

        // Get current component IDs in DB
        $existingIds = $inventory->internal_components()->pluck('id')->toArray();

        // IDs from the request (existing ones)
        $incomingIds = collect($newComponents)
            ->pluck('id') // 'id' might be missing for new components
            ->filter()
            ->toArray();

        // Delete components that are in DB but not in request
        $toDelete = array_diff($existingIds, $incomingIds);
        InventoryInternalComponent::whereIn('id', $toDelete)->delete();

        // Add or update components from request
        foreach ($newComponents as $component) {
            if (isset($component['id']) && in_array($component['id'], $existingIds)) {
                // Update existing
                $comp = InventoryInternalComponent::find($component['id']);
                $comp->update([
                    'brand_model_id' => $component['brand_model']['id'],
                    'quantity'       => $component['quantity'],
                ]);
            } else {
                // Create new
                InventoryInternalComponent::create([
                    'inventory_id'   => $inventory->id,
                    'brand_model_id' => $component['brand_model']['id'],
                    'quantity'       => $component['quantity'],
                ]);
            }
        }
      } else {
        // If item type changed, remove all internal components
        $inventory->internal_components()->delete();
      }

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
            ->orWhere(function ($queryBuilder) use ($query) {
                $queryBuilder
                    ->whereHas('employee', function ($q) use ($query) {
                        $q->where('full_name', 'like', "%$query%");
                    })
                    ->orWhere(function ($q2) use ($query) {
                        $q2->whereDoesntHave('employee')
                            ->whereHas('parent_component.employee', function ($q3) use ($query) {
                                $q3->where('full_name', 'like', "%$query%");
                            });
                    });
            })
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

      $exclude_id = $request->get('exclude_id');

      $inventories = Inventory::query()
          ->when($query, function ($qBuilder) use ($query) {
            $qBuilder->where('property_number', 'like', "%$query%")
                ->whereHas('item_type', function ($q4) {
                    $q4->where('is_main_inventory', true)
                        ->where('is_component', false);
                });
        })
        ->when($exclude_id, function ($qBuilder) use ($exclude_id) {
            $qBuilder->where('id', '!=', $exclude_id);
        })
        ->offset($offset)
        ->limit($limit)
        ->get();  

      return response()->json([
          'data' => InventoryResource::collection($inventories),
      ]);
    }
}
