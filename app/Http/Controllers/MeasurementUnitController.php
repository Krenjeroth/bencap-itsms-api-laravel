<?php

namespace App\Http\Controllers;

use App\Models\MeasurementUnit;
use Illuminate\Http\Request;
use App\Http\Resources\MeasurementUnitResource;
use App\Http\Requests\StoreMeasurementUnitRequest;
use App\Http\Requests\UpdateMeasurementUnitRequest;

class MeasurementUnitController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('item_type_index');

      $query = MeasurementUnit::query();

      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('name', 'LIKE', "%{$search}%")
          ->orWhere('abbreviation', 'LIKE', "%{$search}%")
          ->orWhere('description', 'LIKE', "%{$search}%");
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
          'data' => MeasurementUnitResource::collection($items),
          'meta' => [
              'total' => $items->total(),
              'per_page' => $items->perPage(),
              'current_page' => $items->currentPage(),
              'last_page' => $items->lastPage(),
          ]
      ]);
    }

    public function store(StoreMeasurementUnitRequest $request) {
      // Gate::authorize('item_store');
      
      $data = $request->validated();

      $item = MeasurementUnit::create($data);

      return new MeasurementUnitResource($item);
    }

    public function update(UpdateMeasurementUnitRequest $request, MeasurementUnit $item) {
      // Gate::authorize('item_update');

      $data = $request->validated();

      $item->update($data);

      return new MeasurementUnitResource($item);
    }

    public function destroy(MeasurementUnit $item) {
      // Gate::authorize('item_destroy');

      $item->delete();
      
      return new MeasurementUnitResource($item);
    }
}
