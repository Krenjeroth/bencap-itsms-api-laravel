<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandModel;
use App\Http\Resources\BrandModelResource;
use App\Http\Requests\StoreBrandModelRequest;
use App\Http\Requests\UpdateBrandModelRequest;

class BrandModelController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('brand_model_index');

      $query = BrandModel::query();

      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('name', 'LIKE', "%{$search}%");
        });
      }

      // Sorting (default to ID)
      if ($request->has('sort')) {
        $order = $request->input('order', 'asc');
        $query->orderBy($request->sort, $order);
      }

      // Paginate with customizable per-page count
      $brand_models = $query->paginate($request->input('per_page', 5))->appends($request->query());

      return response()->json([
          'data' => BrandModelResource::collection($brand_models),
          'meta' => [
              'total' => $brand_models->total(),
              'per_page' => $brand_models->perPage(),
              'current_page' => $brand_models->currentPage(),
              'last_page' => $brand_models->lastPage(),
          ]
      ]);
    }

    public function store(StoreBrandModelRequest $request) {
      // Gate::authorize('brand_store');
      
      $data = $request->validated();

      $brand_model = BrandModel::create($data);

      return new BrandModelResource($brand_model);
    }

    public function update(UpdateBrandModelRequest $request, BrandModel $brand_model) {
      // Gate::authorize('brand_update');

      $data = $request->validated();

      $brand_model->update($data);

      return new BrandModelResource($brand_model);
    }

    public function destroy(BrandModel $brand_model) {
      // Gate::authorize('brand_destroy');

      $brand_model->delete();
      
      return new BrandModelResource($brand_model);
    }
}
