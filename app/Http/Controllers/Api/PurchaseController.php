<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

// models
use App\Models\Purchase;
use App\Models\DocumentNumber;
use App\Models\PurhcaseHeader;


class PurchaseController extends Controller
{
  public function index()
  {
    $document_numbers = DocumentNumber::with('purchases')
      ->withCount('purchases')
      ->withSum('purchases', 'price')
      ->latest('id')->limit(1000)->get();

    $document_number_counter = DocumentNumber::query()->where('transaction_type', 'PURCHASE')->count();

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $document_numbers]);
  }

  public function store(Request $request)
  {

    $head = $request->head;
    $items = $request->items;

    $document_number_counter = DocumentNumber::query()->where('transaction_type', 'PURCHASE')->count();

    try {
      $document_numbers = DocumentNumber::create([
        'document_no' => $head['document_no'],
        'uuid' => Str::uuid(),
        'transaction_date' => Carbon::createFromFormat('m-d-Y', $head['transaction_date']),
        'transaction_type' => 'PURCHASE',
      ]);

      PurhcaseHeader::create([
        'document_id' => $document_numbers->id,
        'description1' => $head['description'] ?? '',
        'description2' => $head['description1'] ?? '',
      ]);

      foreach ($items as $key => $item) {
        $purchases = Purchase::create([
          'document_id' => $document_numbers->id,
          'product_id' => $item['id'],
          'category_id' => $item['category_id'],
          'brand_id' => $item['brand_id'],
          'quantity' => $item['quantity'],
          'price' => $item['original_price'],
        ]);
      }

      return response()->json(['status' => true, 'message' => 'Saving success.']);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function show(string $uuid)
  {
    $document_numbers = DocumentNumber::with('purchases.purchased_product')
      ->where(['uuid' => $uuid])
      ->first();

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $document_numbers]);
  }

  public function update(Request $request, $id)
  {

    $head = $request->head;
    $items = $request->items;

    try {
      $document_numbers = DocumentNumber::where('id', $id)->update([
        'document_no' => $head['document_no'],
        'transaction_date' => Carbon::createFromFormat('m-d-Y', $head['transaction_date']),
        'transaction_type' => 'PURCHASE',
      ]);

      foreach ($items as $key => $item) {
        $purchases = Purchase::create([
          // head
          'document_id' => $document_numbers->id,
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
