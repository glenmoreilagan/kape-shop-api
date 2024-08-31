<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Brand;

class BrandController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $search = $request->search;
    $offset = $request->offset;
    $limit = $request->limit;

    $brand = Brand::query();

    $brandCount = $brand->count();

    $brand = $brand->when($limit > 0, function ($query) use ($limit, $offset) {
      $query->limit($limit);
      $query->skip($offset);
    })->where('brand', 'LIKE', '%' . $search . '%')->latest();

    $brand = $brand->get();

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $brand, 'total_item' => $brandCount]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $brand = Brand::create([
      'uuid' => Str::uuid(),
      'brand' => $request->brand,
    ]);

    return response()->json(['status' => true, 'message' => 'Insert success.', 'data' => $brand]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $brand = Brand::find($id);

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $brand]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $brand = Brand::find($id);
    $brand->brand = $request->brand;
    $brand->save();

    return response()->json(['status' => true, 'message' => 'Update success.', 'data' => $brand]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $brand = Brand::find($id);
    $brand->delete();

    return response()->json(['status' => true, 'message' => 'Delete success.']);
  }
}
