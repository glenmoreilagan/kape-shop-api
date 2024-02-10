<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Category;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $category = Category::withCount('products')->latest()->get();

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $category]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $category = Category::create([
      'uuid' => Str::uuid(),
      'category' => $request->category,
    ]);

    return response()->json(['status' => true, 'message' => 'Insert success.', 'data' => $category]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $category = Category::find($id);

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $category]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $category = Category::find($id);
    $category->category = $request->category;
    $category->save();

    return response()->json(['status' => true, 'message' => 'Update success.', 'data' => $category]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $category = Category::find($id);
    $category->delete();

    return response()->json(['status' => true, 'message' => 'Delete success.']);
  }
}
