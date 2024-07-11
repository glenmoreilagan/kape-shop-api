<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  use HasFactory;

  protected $table = 'sales';

  protected $fillable = [
    'document_id',
    'product_id',
    'quantity',
    'price',
    'total',
    'created_by',
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
  }
}
