<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\CustomEmailVerificationNotification;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'provider',
    'provider_user_id',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
    'provider',
    'provider_user_id',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  public function name(): Attribute
  {
    return Attribute::make(
      set: fn(string $value) => Str::title($value),
    );
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new CustomResetPasswordNotification($token));
  }

  public function sendEmailVerificationNotification()
  {
    $this->notify(new CustomEmailVerificationNotification());
  }
}
