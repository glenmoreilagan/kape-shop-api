<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Purchase;

class DocumentNumber extends Model
{
  use HasFactory;

  protected $table = 'document_numbers';
  protected $fillable = ['document_no'];


  public function purchases()
  {
    return $this->hasMany(Purchase::class, 'document_id', 'id');
  }
}
