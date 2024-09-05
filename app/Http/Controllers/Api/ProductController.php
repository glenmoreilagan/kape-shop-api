<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

use App\Http\Requests\ProductRequest;

use Illuminate\Support\Str;

use App\Traits\StockBalance;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
  use StockBalance;
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $search = $request->search ?? '';
    $offset = $request->offset ?? 0;
    $limit = $request->limit ?? 10;

    $products = Product::query();

    $productCount = $products->count();

    $products = $products->with(['categories:id,category', 'brands:id,brand'])
      ->when($limit > 0, function ($query) use ($limit, $offset) {
        $query->limit($limit);
        $query->skip($offset);
      })
      ->where('name', 'LIKE', '%' . $search . '%')
      ->withSum('sales', 'total')
      ->withCount('sales')
      ->oldest('id');

    $products = $products->get();

    /* 
      I wrote this for 1 liner code
      but I saw some comments in stackoverflow
      says foreach is better performance for large data
      https://stackoverflow.com/questions/18592836/eloquent-collections-each-vs-foreach 
    */
    
    // $products->each(fn($row) => $row->stocks = ($row->purchase_stocks_sum_quantity - $row->sale_stocks_sum_quantity));

    foreach ($products as $key => $product) {
      $product->stocks = $this->stocks($product->id);
    }

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $products, 'total_item' => $productCount]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ProductRequest $request)
  {
    $product = Product::create([
      'name' => $request->name,
      'sku' => $request->sku,
      'uuid' => Str::uuid(),
      'category_id' => $request->category_id,
      'brand_id' => $request->brand_id,
      'description1' => $request->description1,
      'description2' => $request->description2,
      'price' => $request->price,
      'product_status' => $request->product_status,
    ]);

    return response()->json(['status' => true, 'message' => 'Insert success.', 'data' => $product]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $product = Product::where('uuid', $id)->first();

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $product]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $uuid)
  {
    $product = Product::where('uuid', $uuid)->firstOrFail();
    $product->name = $request->name;
    $product->sku = $request->sku;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;
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
