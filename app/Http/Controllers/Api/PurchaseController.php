<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

// models
use App\Models\Purchase;
use App\Models\DocumentNumber;

class PurchaseController extends Controller
{
  public function index()
  {
    $document_numbers = DocumentNumber::with('purchases')
      ->withCount('purchases')
      ->withSum('purchases', 'price')
      ->latest('id')->limit(1000)->get();

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $document_numbers]);
  }

  public function store(Request $request)
  {

    $head = $request->head;
    $items = $request->items;

    $transaction_date = explode("-", $head['transaction_date']);
    $transaction_date = $transaction_date[1] . "-" . $transaction_date[0] . "-" . $transaction_date[2];

    try {
      $document_numbers = DocumentNumber::create([
        'document_no' => $head['document_no']
      ]);
      foreach ($items as $key => $item) {
        $purchases = Purchase::create([
          // head
          'document_id' => $document_numbers->id,
          'transaction_date' => $transaction_date,
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

  public function show(string $document_no, int $id)
  {
    $document_numbers = DocumentNumber::with('purchases.purchased_product')
      ->where(['id' => $id, 'document_no' => $document_no])
      ->withCount('purchases')
      ->withSum('purchases', 'price')
      ->first();

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $document_numbers]);
  }
}
