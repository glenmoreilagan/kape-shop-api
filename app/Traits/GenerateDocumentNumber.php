<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GenerateDocumentNumber
{

  public function getDocumentNumber()
  {
    return Str::ulid();
  }
}
