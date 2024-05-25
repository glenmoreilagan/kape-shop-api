<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TransactionTypeEnum extends Enum
{
  const PURCHASES = 'PURCHASES';
  const SALES = 'SALES';
}
