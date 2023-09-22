<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurhcaseHeader extends Model
{
  use HasFactory;

  protected $table = 'purhcase_headers';
  protected $fillable = [
    'document_id',
    'description1',
    'description2',
  ];
}
