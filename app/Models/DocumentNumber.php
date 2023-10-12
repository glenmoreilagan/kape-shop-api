<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Purchase;
use Carbon\Carbon;

class DocumentNumber extends Model
{
  use HasFactory;

  protected $table = 'document_numbers';
  protected $fillable = ['uuid', 'document_no', 'transaction_date', 'transaction_type'];

  protected function transactionDate(): Attribute
  {
    return Attribute::make(
      get: fn (string $value) => Carbon::parse($value)->format('m-d-Y'),
      set: fn (string $value) => Carbon::parse($value),
    );
  }

  public function purchases()
  {
    return $this->hasMany(Purchase::class, 'document_id', 'id');
  }
}
