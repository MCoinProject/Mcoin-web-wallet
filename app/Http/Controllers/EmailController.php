<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    public function notifyTransfer($user, $amount, $address, $code)
    {
    	$link = url('/validate?txn='.$code);

    	Log::useFiles(storage_path().'/logs/transfers.log', 'info');
        Log::info('User : '.$user->email.'; Transfer address : '.$address.'; Amount : '.$amount);
        
        Mail::send('emails.transfer_notification', ['user' => $user, 'amount' => $amount, 'address' => $address, 'link' => $link], 
            function ($message) use ($user) {
            $message->to($user->email, $user->name)->subject("ETP Wallet - Transfer Confirmation");
        });
    }
}
