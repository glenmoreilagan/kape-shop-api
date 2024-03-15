<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
  /**
   * Handle an incoming authentication request.
   */
  public function store(LoginRequest $request): Response
  {
    $request->authenticate();

    $request->session()->regenerate();

    return response()->noContent();
  }

  /**
   * Destroy an authenticated session.
   */
  public function destroy(Request $request): Response
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return response()->noContent();
  }

  public function socialMediaLogin(Request $request)
  {
    $user = User::updateOrCreate(
      [
        'provider_user_id' => $request->id
      ],
      [
        'name' => $request->name,
        'email' => $request->email,
        'provider' => $request->provider,
        'provider_user_id' => $request->id,
      ]
    );

    Auth::login($user);

    return response()->json(Auth::user(), 201);
  }
}
