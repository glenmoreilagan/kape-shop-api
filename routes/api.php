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
use App\Models\User;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('/test', function () {
  return User::query()->where('id', 10)->value('email');
});

Route::middleware(['auth:sanctum'])->group(function () {
  Route::apiResource('/brands', BrandController::class);
  Route::apiResource('/categories', CategoryController::class);
  Route::apiResource('/products', ProductController::class);
  Route::apiResource('/sales', SaleController::class);

  Route::prefix('purchases')->group(function () {
    Route::put('/update-quantity/{id}', [PurchaseController::class, 'updateQuantity']);
    Route::post('/add-product', [PurchaseController::class, 'addProducts']);
    Route::get('/generate-document-number', [PurchaseController::class, 'generateDocumentNumber']);
  });
  Route::apiResource('/purchases', PurchaseController::class);

  Route::get('/dropdown/categories', [DropdownMenuController::class, 'categories']);
  Route::get('/dropdown/brands', [DropdownMenuController::class, 'brands']);
});