<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RoleEnum extends Enum
{
  const SuperAdministrator = 1;
  const Administrator = 2;
  const Moderator = 3;
  const Cashier = 4;
  const Customer = 5;
}
