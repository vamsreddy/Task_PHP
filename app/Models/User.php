<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $fillable= [
        'username',
        'email',
        'password',
        'confirm_password',
        'phone'
    ];

    protected $hidden = [
        'password','confirm_password' ,'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $url = '/reset-password?token=' . $token;
        $this->notify(new ResetPasswordNotification($url));
    }

}
