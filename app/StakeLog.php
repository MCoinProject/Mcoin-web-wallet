<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StakeLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stake_id',
        'start_at',
        'stop_at',
    ];
}
