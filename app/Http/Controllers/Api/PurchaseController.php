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
    $head = $request->head;
    $items = $request->items;

    try {
      foreach ($items as $key => $item) {
        $purchases = Purchase::create([
          // head
          'document_no' => $head['document_no'],
          'transaction_date' => $head['transaction_date'],
          'document_no' => $head['document_no'],
          'description' => $head['description'] ?? '',
          'description1' => $head['description1'] ?? '',

          // items
          'product_id' => $item['id'],
          'category_id' => $item['category_id'],
          'brand_id' => $item['brand_id'],
          'quantity' => $item['quantity'],
          'price' => $item['original_price'],
        ]);
      }

      return response()->json(['status' => true, 'document_no' => $head['document_no']]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
