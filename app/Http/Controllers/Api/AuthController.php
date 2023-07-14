<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $request->validate([
      'email' => ['required', 'string', 'email'],
      'password' => ['required'],
    ]);

    if (!Auth::attempt($request->only(['email', 'password']), $request->remember)) {
      abort(400, 'Please check email and password');
    }

    $user = User::where('email', $request->email)->first();
    $token = $user->createToken($request->email)->plainTextToken;

    $response = [
      'user' => $user,
      'token' => $token,
    ];

    return response()->json(['status' => true, 'data' => $response]);
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed'],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);

    /** send email notification to user */
    // event(new Registered($user));

    return response()->noContent();
  }

  public function logout(Request $request)
  {
    request()->user()->tokens()->delete();

    return response()->noContent();
  }
}
