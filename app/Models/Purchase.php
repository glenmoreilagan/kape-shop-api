<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Purchase extends Model
{
  use HasFactory;

  protected $table = 'purchases';
  protected $fillable = [
    'document_no',
    'transaction_date',
    'document_no',
    'description',
    'description1',
    'product_id',
    'category_id',
    'brand_id',
    'quantity',
    'category_id',
    'brand_id',
    'price',
  ];

  protected function transactionDate(): Attribute
  {
    return Attribute::make(
      get: fn (string $value) => $value,
      set: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
    );
  }
}
