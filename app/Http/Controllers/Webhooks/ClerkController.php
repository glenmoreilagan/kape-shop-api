<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClerkController extends Controller
{
  const USER_CREATED = 'user.created';
  const SESSION_CREATED = 'session.created';
  const SESSION_ENDED = 'session.ended';

  public function __invoke(Request $request): void
  {

    $data = $request->data;
    $type = $request->type;

    // Login
    if ($type == self::USER_CREATED) {
      $user_id = $data['id'];
      $first_name = $data['first_name'];
      $last_name = $data['last_name'];
      $provider = $data['external_accounts'][0]['object'];
      $email_address = $data['external_accounts'][0]['email_address'];

      $user = User::updateOrCreate(
        [
          'provider_user_id' => $user_id
        ],
        [
          'name' => "$last_name, $first_name",
          'email' => $email_address,
          'provider' => $provider,
          'provider_user_id' => $user_id,
          'password' => bcrypt('password')
        ]
      );

      Auth::login($user);
    }

    // Login with existing user in clerk
    if ($type == self::SESSION_CREATED) {
      $user_id = $data['user_id'];
      $user = User::query()->where('provider_user_id', $user_id)->first();

      Auth::login($user);
    }

    // Logout
    if ($type == self::SESSION_ENDED) {
      Auth::logout();
    }
  }
}
