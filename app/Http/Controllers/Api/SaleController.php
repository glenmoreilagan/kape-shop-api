<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\DocumentNumber;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use App\Enums\TransactionTypeEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
  public function index(Request $request)
  {
    $search = $request->search;
    $offset = $request->offset;
    $limit = $request->limit;

    $sales = DocumentNumber::query()
      ->where('document_no', 'LIKE', '%' . $search . '%')
      ->withSum('sales', 'total')
      ->withCount('sales')
      ->latest('id');

    $salesCount = $sales->count();

    if ($limit > 0) {
      $sales = $sales->limit($limit);
      $sales = $sales->skip($offset);
    }

    $sales = $sales->get();

    return response()->json(['status' => true, 'message' => 'Fetch success.', 'data' => $sales, 'total_item' => $salesCount]);

    return response()->json($sales);
  }

  public function store(Request $request)
  {
    $payload = $request->data;

    $document_number = DocumentNumber::create([
      // 'uuid' => Str::uuid(),
      // 'document_no' => Str::ulid(),
      'transaction_date' => Carbon::now(),
      'transaction_type' => TransactionTypeEnum::SALES,
    ]);

    // $user = User::query()->where('provider_user_id', $$request->user_id)->first();

    foreach ($payload as $key => $row) {
      Sale::create([
        'document_id' => $document_number->id,
        "product_id" => $row['id'],
        "price" => $row['price'],
        "quantity" => $row['qty'],
        "user_id" => Auth::id(),
      ]);
    }

    return response()->noContent(201);
  }
}
