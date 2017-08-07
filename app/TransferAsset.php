<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferAsset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'target_email',
        'sender_address',
        'receiver_address',
        'amount',
        'description',
        'code',
        'status',
    ];

    public $appends = ['user'];

    public function getUserAttribute()
    {
        return $this->belongsTo('App\User', 'user_id')->first();
    }
}
