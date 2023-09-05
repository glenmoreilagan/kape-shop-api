<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $product = Product::with([
      'category' => function ($q) {
        $q->select('id', 'category');
      }
    ])
      ->latest('id')->limit(1000)->get();

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $product]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ProductRequest $request)
  {
    $product = Product::create([
      'name' => $request->productName,
      'sku' => $request->sku,
      'category_id' => $request->category,
      'brand_id' => $request->brand,
      'description1' => $request->description1,
      'description2' => $request->description2,
      'price' => $request->price,
      'product_status' => $request->productStatus,
    ]);

    return response()->json(['status' => true, 'message' => 'Insert success.', 'data' => $product]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $product = Product::find($id);

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $product]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $product = Product::find($id);
    $product->name = $request->name;
    $product->sku = $request->sku;
    $product->description1 = $request->description1;
    $product->description2 = $request->description2;
    $product->price = $request->price;
    $product->product_status = $request->product_status;
    $product->save();

    return response()->json(['status' => true, 'message' => 'Update success.', 'data' => $product]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $product = Product::find($id);
    $product->delete();

    return response()->json(['status' => true, 'message' => 'Delete success.']);
  }
}
