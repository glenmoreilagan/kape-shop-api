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
    DocumentNumber::create([
      'document_no' => $request->document_no,
      'uuid' => Str::uuid(),
      'description1' => $request->description1 ?? '',
      'description2' => $request->description2 ?? '',
      'transaction_date' => Carbon::parse($request->transaction_date),
      'transaction_type' => 'PURCHASE',
    ]);

    return response()->json(['status' => true, 'message' => 'Saving success.']);
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
    DocumentNumber::where('id', $id)->update([
      'document_no' => $request->document_no,
      'description1' => $request->description1 ?? '',
      'description2' => $request->description2 ?? '',
      'transaction_date' => Carbon::parse($request->transaction_date),
    ]);

    return response()->json(['status' => true, 'message' => 'Update success.']);
  }

  public function updateQuantity(Request $request, $id)
  {
    $new_qty = $request->quantity;
    $action = $request->action;

    switch ($action) {
      case 'increment':
        Purchase::where('id', $id)->increment('quantity', $new_qty);
        break;
      case 'decrement':
        Purchase::where('id', $id)->decrement('quantity', $new_qty);
        break;
      case 'manual':
        Purchase::where('id', $id)->update(['quantity' => $new_qty]);
        break;

      default:
        return response()->json(['message' => 'No Action Found.'], 400);
        break;
    }

    return response()->noContent();
  }

  public function addProducts(Request $request)
  {
    return $request->all();
  }
}
