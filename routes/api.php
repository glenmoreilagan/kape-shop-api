<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EnumsController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DropdownMenuController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\SaleController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
  return $request->user();
});

Route::put('/purchases/update-quantity/{id}', [PurchaseController::class, 'updateQuantity']);
Route::post('/purchases/add-product', [PurchaseController::class, 'addProducts']);



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);


Route::middleware(['auth:sanctum'])->group(function () {
  Route::apiResource('/brands', BrandController::class);
  Route::apiResource('/categories', CategoryController::class);
  Route::apiResource('/products', ProductController::class);
  Route::apiResource('/purchases', PurchaseController::class);
  Route::apiResource('/sales', SaleController::class);

  Route::get('/dropdown/categories', [DropdownMenuController::class, 'categories']);
  Route::get('/dropdown/brands', [DropdownMenuController::class, 'brands']);
});
