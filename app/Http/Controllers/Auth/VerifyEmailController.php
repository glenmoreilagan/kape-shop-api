<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
  /**
   * Mark the authenticated user's email address as verified.
   */
  public function __invoke(Request $request): RedirectResponse
  {
    $user = User::find(10);
    if ($user->hasVerifiedEmail()) {
      return redirect()->intended(
        config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
      );
    }

    if ($user->markEmailAsVerified()) {
      // send this email that notify its verified
      // event(new Verified($request->user()));
    }

    return redirect()->intended(
      config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
    );
  }
}
