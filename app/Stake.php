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

    public $appends = ['total_profix'];

    public function getLogsAttribute()
    {
        return $this->hasMany('App\StakeLogs', 'stake_id')->first();
    }

    /*
     *  Get total stake profit from staking every month
     */
    public function getTotalProfitAttribute()
    {
        // $startStake = Stake::where();
    }
}
