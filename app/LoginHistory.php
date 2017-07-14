<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ip_address'
    ];

    public $appends = ['user'];

    public function getUserAttribute()
    {
    	return $this->belongsTo('App\User', 'user_id')->first();
    }
}
