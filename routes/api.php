<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EnumsController;
use App\Http\Controllers\Api\ProductController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('enums', EnumsController::class);


Route::apiResource('/brands', BrandController::class);
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/products', ProductController::class);
