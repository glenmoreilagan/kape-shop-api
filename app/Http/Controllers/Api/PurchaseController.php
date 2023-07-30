<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
  public function store(Request $request)
  {
    $items = $request->items;
    $purchases_response = [];

    try {
      foreach ($items as $key => $item) {
        $purchases = Purchase::create([
          'product_id' => $item['product_id'],
          'category_id' => $item['category_id'],
          'brand_id' => $item['brand_id'],
          'quantity' => $item['quantity'],
          'price' => $item['price'],
        ]);

        array_push($purchases_response, $purchases);
      }

      return response()->json(['status' => true, 'data' => $purchases_response]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
