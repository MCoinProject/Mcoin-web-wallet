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
        'sender_address',
        'receiver_address',
        'amount',
        'description',
        'miner_fee',
    ];
}
