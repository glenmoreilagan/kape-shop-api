<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;

class SaleController extends Controller
{
  public function store(Request $request)
  {
    $payload = $request->data;

    foreach ($payload as $key => $row) {
      $sale =  Sale::create([
        'document_id' => 1,
        "product_id" => $row['id'],
        "price" => $row['price'],
        "quantity" => $row['qty'],
        "created_by" => 5,
      ]);
    }

    return response()->noContent(201);
  }
}
