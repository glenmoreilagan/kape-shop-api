<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function annualSales(Request $request)
  {
    $annual_sales = Sale::query()
      ->selectRaw("SUM(price * quantity) as total_of_month")
      ->selectRaw("MONTH(created_at) as month")
      ->groupBy('month')
      ->get();


    $weekly_sales = Sale::query()
      ->where(function ($qry) {
        $qry->whereDate('created_at', '>=', Carbon::now()->subWeek());
        $qry->whereDate('created_at', '<=', Carbon::now());
      })
      ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as formatted_created_at")
      ->selectRaw("SUM(price * quantity) as total_of_day")
      ->groupBy('formatted_created_at')
      ->get();

    $daily_sales = Sale::query()
      ->where(function ($qry) {
        $qry->whereDate('created_at', Carbon::now());
      })
      ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as formatted_created_at")
      ->selectRaw("SUM(price * quantity) as total_of_day")
      ->groupBy('formatted_created_at')
      ->get();

    return response()->json([
      'chart' => [
        'annual' => $annual_sales,
        'weekly' => $weekly_sales
      ],
      'panel' => [
        'daily_sales' => $daily_sales,
      ],
    ]);
  }
}
