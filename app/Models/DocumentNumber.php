<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Purchase;
use App\Models\Sale;

use Carbon\Carbon;
use Illuminate\Support\Str;

class DocumentNumber extends Model
{
  use HasFactory;

  protected $table = 'document_numbers';
  protected $fillable = ['uuid', 'description1', 'description2', 'document_no', 'transaction_date', 'transaction_type'];
  protected $attributes = [
    'uuid' => null,
    'document_no' => null,
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->uuid = (string) Str::uuid();
      $model->document_no = $model->document_no ?? (string) Str::ulid();
    });
  }

  protected function transactionDate(): Attribute
  {
    return Attribute::make(
      get: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
    );
  }

  public function purchases()
  {
    return $this->hasMany(Purchase::class, 'document_id', 'id');
  }

  public function sales()
  {
    return $this->hasMany(Sale::class, 'document_id', 'id');
  }
}
