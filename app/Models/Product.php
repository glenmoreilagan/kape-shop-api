<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Sale;

use Illuminate\Support\Facades\DB;

class Product extends Model
{
  use HasFactory;

  protected $table = 'products';
  protected $fillable = [
    'uuid',
    'sku',
    'name',
    'description1',
    'description2',
    'category_id',
    'brand_id',
    'price',
    'product_status',
  ];


  public function categories()
  {
    return $this->hasOne(Category::class, 'id', 'category_id');
  }

  public function brands()
  {
    return $this->hasOne(Brand::class, 'id', 'brand_id');
  }

  public function sales()
  {
    return $this->hasMany(Sale::class, 'product_id', 'id');
  }
}
