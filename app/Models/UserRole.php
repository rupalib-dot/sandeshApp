<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class UserRole extends Authenticatable
{ 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps    = false;
    protected $table    = 'role_user';
    protected $fillable = [
        'id',
        'role_id',
        'user_id', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */ 

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */ 

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */ 
 
}
