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
use App\Models\Product;
use App\Models\PurhcaseHeader;
use Illuminate\Support\Facades\App;

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
    $document = DocumentNumber::create([
      'document_no' => $request->document_no,
      'uuid' => Str::uuid(),
      'description1' => $request->description1 ?? '',
      'description2' => $request->description2 ?? '',
      'transaction_date' => Carbon::parse($request->transaction_date),
      'transaction_type' => 'PURCHASE',
    ]);

    return response()->json($document);
  }

  public function show(string $uuid)
  {
    $document = DocumentNumber::where(['uuid' => $uuid])->first();

    abort_if(!$document, '404', 'Document not found.');

    $purchases = $this->getPurhcasesByDocumentId($document->id);

    return response()->json(['document' => $document, 'purchases' => $purchases]);
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
    $document_id = $request->document['id'];
    $products = $request->products;

    foreach ($products as $key => $row) {
      Purchase::create([
        'document_id' => $document_id,
        'product_id' => $row['id'],
        'category_id' => $row['category_id'],
        'brand_id' => $row['brand_id'],
        'quantity' => 1,
        'price' => $row['price'],
      ]);
    }


    $purchases = $this->getPurhcasesByDocumentId($document_id);
    
    return response()->json($purchases);
  }

  private function getPurhcasesByDocumentId($document_id)
  {
    return Purchase::where('purchases.document_id', $document_id)
      ->join(App(Product::class)->getTable() . ' as product', 'product.id', '=', 'purchases.product_id')
      ->select([
        'purchases.id as id',
        'purchases.category_id as category_id',
        'purchases.brand_id as brand_id',
        'purchases.price as price',
        'purchases.quantity as quantity',

        'product.id as product_id',
        'product.name as name',
        'product.uuid as product_uuid',
        'product.sku as sku',
      ])
      ->get();
  }
}
