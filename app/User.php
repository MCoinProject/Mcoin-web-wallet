<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\TransferAsset;

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

    public $appends = ['wallet', 'profile', 'max_transfer'];

    public function getWalletAttribute()
    {
        return $this->hasOne('App\Wallet', 'user_id')->first();
    }

    public function getProfileAttribute()
    {
        return $this->hasOne('App\Profile', 'user_id')->first();
    }

    public function getMaxTransferAttribute()
    {
        // Declare Miner Fee
        $miner_fee = 0.01;

        return $this->getTotalBalance() - $miner_fee;
    }

    /*
     * Get total transfered amount in wallet
     */
    public function getTotalTransfered()
    {
        return TransferAsset::where('user_id', $this->id)->sum('amount');
    }

    /*
     * Get total received amount in wallet
     */
    public function getTotalReceived()
    {
        return TransferAsset::where('receiver_address', $this->receiver_address)
        ->where('status', 'success')
        ->sum('amount');
    }

    /*
     * Get total balance amount in wallet
     */
    public function getTotalBalance()
    {
        return $this->getTotalReceived() - $this->getTotalTransfered();
    }
}
