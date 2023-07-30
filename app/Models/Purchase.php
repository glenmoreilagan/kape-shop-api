<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  use HasFactory;

  protected $table = 'purchases';
  protected $fillable = [
    'product_id',
    'category_id',
    'brand_id',
    'quantity',
    'category_id',
    'brand_id',
    'price',
  ];
}
