<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;

trait StockBalance
{
  public function stocks(int $product_id)
  {
    if (!$product_id) return 0;

    $product = Product::query()
      ->where('id', $product_id)
      ->withSum([
        'saleStocks' => fn($query) => $query->select(DB::raw('COALESCE(SUM(quantity), 0)')),
      ], 'quantity')
      ->withSum([
        'purchaseStocks' => fn($query) => $query->select(DB::raw('COALESCE(SUM(quantity), 0)')),
      ], 'quantity')
      ->first();

    $product['stocks'] = $product->purchase_stocks_sum_quantity - $product->sale_stocks_sum_quantity;
    // foreach ($products as $key => $product) {
    //   $product['stocks'] = $product->purchase_stocks_sum_quantity - $product->sale_stocks_sum_quantity;
    // }

    return $product->stocks ?? 0;
  }
}
