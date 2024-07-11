<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\DocumentNumber;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class Purchase extends Model
{
  use HasFactory;

  protected $table = 'purchases';
  protected $fillable = [
    'document_id',
    'product_id',
    'category_id',
    'brand_id',
    'quantity',
    'price',
    'total',
  ];

  protected $attributes = [
    'total' => 0,
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->total = $model->quantity * $model->price;
    });

    static::updating(function ($model) {
      $model->total = $model->quantity * $model->price;
    });
  }


  public function documentNumber()
  {
    return $this->hasOne(DocumentNumber::class, 'id', 'document_id');
  }

  public function category()
  {
    return $this->hasOne(Category::class, 'id', 'category_id');
  }

  public function brand()
  {
    return $this->hasOne(Brand::class, 'id', 'brand_id');
  }

  public function product()
  {
    return $this->hasMany(Product::class, 'id', 'product_id');
  }

  public function purchased_product()
  {
    return $this->hasOne(Product::class, 'id', 'product_id');
  }
}
