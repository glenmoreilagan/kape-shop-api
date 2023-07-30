<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\Category;

class DropdownMenuController extends Controller
{
  public function categories(Request $request)
  {
    $categories = Category::orderBy('category')->select(['id as value', 'category as label'])->get();

    return response()->json($categories);
  }

  public function brands(Request $request)
  {
    $brands = Brand::orderBy('brand')->select(['id as value', 'brand as label'])->get();

    return response()->json($brands);
  }
}
