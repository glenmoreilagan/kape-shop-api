<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\DocumentNumber;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SaleController extends Controller
{
  public function store(Request $request)
  {
    $payload = $request->data;

    $document_number = DocumentNumber::create([
      'uuid' => Str::uuid(),
      'document_no' => Str::ulid(),
      'transaction_date' => Carbon::now(),
      'transaction_type' => 'SALES',
    ]);

    foreach ($payload as $key => $row) {
      Sale::create([
        'document_id' => $document_number->id,
        "product_id" => $row['id'],
        "price" => $row['price'],
        "quantity" => $row['qty'],
        "created_by" => auth()->id(),
      ]);
    }

    return response()->noContent(201);
  }
}
