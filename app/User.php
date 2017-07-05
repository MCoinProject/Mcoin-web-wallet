<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $appends = ['wallet', 'profile'];

    public function getWalletAttribute()
    {
        return $this->hasOne('App\Wallet', 'user_id')->first();
    }

    public function getProfileAttribute()
    {
        return $this->hasOne('App\Profile', 'user_id')->first();
    }
}
