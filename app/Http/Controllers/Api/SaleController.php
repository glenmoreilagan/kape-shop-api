<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;

class SaleController extends Controller
{
  public function store(Request $request)
  {
    return $request->all();
  }
}
