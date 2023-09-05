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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
  return $request->user();
});

Route::apiResource('/brands', BrandController::class);
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/products', ProductController::class);
Route::get('/purchases/edit/{document_no}/{id}', [PurchaseController::class, 'show']);
Route::apiResource('/purchases', PurchaseController::class)->except('show');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

Route::get('/dropdown/categories', [DropdownMenuController::class, 'categories']);
Route::get('/dropdown/brands', [DropdownMenuController::class, 'brands']);
