<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EnumsController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DropdownMenuController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\SaleController;
use Illuminate\Support\Facades\Broadcast;

use App\Models\User;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('/test', function () {
  return User::query()->where('id', 10)->value('email');
});

Route::middleware(['auth.clerk'])->group(function () {
  // BRANDS
  Route::apiResource('/brands', BrandController::class);

  //CATEGORIES 
  Route::apiResource('/categories', CategoryController::class);

  // PRODUCTS
  Route::put('/products/{uuid}', [ProductController::class, 'update']);
  Route::apiResource('/products', ProductController::class)->except('update');

  // PURCHASES
  Route::prefix('purchases')->group(function () {
    Route::put('/update-quantity/{id}', [PurchaseController::class, 'updateQuantity']);
    Route::post('/add-product', [PurchaseController::class, 'addProducts']);
    Route::get('/generate-document-number', [PurchaseController::class, 'generateDocumentNumber']);
  });
  Route::apiResource('/purchases', PurchaseController::class);

  // SALES
  Route::apiResource('/sales', SaleController::class);

  // DROPDOWNS
  Route::get('/dropdown/categories', [DropdownMenuController::class, 'categories']);
  Route::get('/dropdown/brands', [DropdownMenuController::class, 'brands']);
});

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'annualSales']);

// Broadcast::routes(['middleware' => ['auth:sanctum']]);
Broadcast::routes();