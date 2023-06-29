<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Enums\RoleEnum;

class EnumsController extends Controller
{
	public function __invoke()
	{
    return RoleEnum::SuperAdministrator;
	}
}
