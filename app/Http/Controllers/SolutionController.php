<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solution;
use App\Http\Resources\SolutionResource;
use App\Http\Requests\StoreSolutionRequest;

class SolutionController extends Controller
{
    public function store(StoreSolutionRequest $request) {
      $data = $request->validated();

      $solution = Solution::create($data);

      return new SolutionResource($solution); 
    }

    public function select() {
        $solutions = Solution::all();

        return response()->json([
          'data' => SolutionResource::collection($solutions)
        ]);
    }
}
