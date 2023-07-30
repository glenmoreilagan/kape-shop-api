<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;

class Product extends Model
{
  use HasFactory;

  protected $table = 'products';
  protected $fillable = [
    'sku',
    'name',
    'description1',
    'description2',
    'category_id',
    'brand_id',
    'price',
    'product_status',
  ];


  public function category()
  {
    return $this->hasOne(Category::class, 'id', 'category_id');
  }
}
