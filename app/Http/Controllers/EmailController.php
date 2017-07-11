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
            $message->to($user->email, $user->profile->name)->subject("ETP Wallet - Transfer Confirmation");
        });
    }

    public function notifyRequest($targetEmail, $requester, $amount)
    {
        Log::useFiles(storage_path().'/logs/requests.log', 'info');
        Log::info('Requester : '.$requester->email.'; Target : '.$targetEmail.'; Amount : '.$amount);
        
        Mail::send('emails.request_notification', ['target' => $targetEmail, 'amount' => $amount, 'requester' => $requester], 
            function ($message) use ($targetEmail) {
            $message->to($targetEmail, '')->subject("ETP Wallet - Asset Request");
        });
    }

    public function notifyReceive($targetEmail, $user, $amount)
    {
        Log::useFiles(storage_path().'/logs/received.log', 'info');
        Log::info('Sender : '.$user->email.'; Target : '.$targetEmail.'; Amount : '.$amount);
        
        Mail::send('emails.receive_notification', ['target' => $targetEmail, 'amount' => $amount, 'user' => $user], 
            function ($message) use ($targetEmail) {
            $message->to($targetEmail, '')->subject("ETP Wallet - ETP Received");
        });
    }

    /*
     * Send activation email
     */
    public function notifyActivate($user)
    {   
        // Activation URL
        $url = url('/activation?act='.$user->getActivation()->code);

        // Create Log file
        Log::useFiles(storage_path().'/logs/activation.log', 'info');
        Log::info('Email : '.$user->email);
            
        // Send Activation Email
        Mail::send('emails.activate_notification', ['user' => $user, 'url' => $url], 
            function ($message) use ($user) {
            $message->to($user->email, '')->subject("ETP Wallet - ETP Wallet Activation");
        });
    }
}
