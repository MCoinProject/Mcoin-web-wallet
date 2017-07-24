<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stake extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'start_at',
        'remarks',
        'amount',
    ];

    public $appends = ['logs'];

    public function getLogsAttribute()
    {
        return $this->belongsTo('App\StakeLogs', 'stake_id')->first();
    }
}
