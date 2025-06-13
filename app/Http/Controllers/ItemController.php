<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('item_type_index');

      $query = Item::query();

      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('property_number', 'LIKE', "%{$search}%")
          ->orWhere('parent_component', 'LIKE', "%{$search}%")
          ->orWhere('serial_number', 'LIKE', "%{$search}%")
          ->orWhere('ics_number', 'LIKE', "%{$search}%")
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
          'data' => ItemResource::collection($items),
          'meta' => [
              'total' => $items->total(),
              'per_page' => $items->perPage(),
              'current_page' => $items->currentPage(),
              'last_page' => $items->lastPage(),
          ]
      ]);
    }

    public function store(StoreItemRequest $request) {
      // Gate::authorize('item_store');
      
      $data = $request->validated();

      $item = Item::create($data);

      return new ItemResource($item);
    }

    public function update(UpdateItemRequest $request, Item $item) {
      // Gate::authorize('item_update');

      $data = $request->validated();

      $item->update($data);

      return new ItemResource($item);
    }

    public function destroy(Item $item) {
      // Gate::authorize('item_destroy');

      $item->delete();
      
      return new ItemResource($item);
    }

    public function search(Request $request) {
      $query = $request->get('q');
      $limit = (int) $request->get('limit', 20);
      $page = (int) $request->get('page', 1);
      $offset = ($page - 1) * $limit;

      $items = Item::query()
          ->when($query, fn($qBuilder) =>
              $qBuilder->where('property_number', 'like', "%$query%")
          )
          ->offset($offset)
          ->limit($limit)
          ->get();

      return response()->json([
          'data' => ItemResource::collection($items),
      ]);
    }
}
