<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    /*
     *  Send transfer asset notification email
     */
    public function notifyTransfer($user, $amount, $address, $code)
    {
        // Assign validate url with appended code into var
    	$link = url('/validate?txn='.$code);

        // Set log path to store information after sending email
    	Log::useFiles(storage_path().'/logs/transfers.log', 'info');
        Log::info('User : '.$user->email.'; Transfer address : '.$address.'; Amount : '.$amount);

        // Re set log path to store any erros information
        Log::useFiles(storage_path().'/logs/laravel.log', 'info');
        
        // Send Transfer Notification Email
        Mail::send('emails.transfer_notification', ['user' => $user, 'amount' => $amount, 'address' => $address, 'link' => $link], 
            function ($message) use ($user) {
            $message->to($user->email, $user->profile->name)->subject("ETP Wallet - Transfer Confirmation");
        });
    }

    /*
     *  Send request asset notification email
     */
    public function notifyRequest($targetEmail, $requester, $amount)
    {
        // Set log path to store information after sending email
        Log::useFiles(storage_path().'/logs/requests.log', 'info');
        Log::info('Requester : '.$requester->email.'; Target : '.$targetEmail.'; Amount : '.$amount);

        // Re set log path to store any erros information
        Log::useFiles(storage_path().'/logs/laravel.log', 'info');
        
        // Send Request Notification Email
        Mail::send('emails.request_notification', ['target' => $targetEmail, 'amount' => $amount, 'requester' => $requester], 
            function ($message) use ($targetEmail) {
            $message->to($targetEmail, '')->subject("ETP Wallet - Asset Request");
        });
    }

    /*
     * Send receive asset notification email 
     */
    public function notifyReceive($targetEmail, $user, $amount)
    {
        // Set log path to store information after sending email
        Log::useFiles(storage_path().'/logs/received.log', 'info');
        Log::info('Sender : '.$user->email.'; Target : '.$targetEmail.'; Amount : '.$amount);

        // Re set log path to store any erros information
        Log::useFiles(storage_path().'/logs/laravel.log', 'info');
        
        // Send Receive Notification Email
        Mail::send('emails.receive_notification', ['target' => $targetEmail, 'amount' => $amount, 'user' => $user], 
            function ($message) use ($targetEmail) {
            $message->to($targetEmail, '')->subject("ETP Wallet - ETP Received");
        });
    }

    /*
     * Send activation notification email
     */
    public function notifyActivate($user)
    {   
        // Assign validate url with appended code into var
        $url = url('/activation?act='.$user->getActivation()->code);

        // Set log path to store information after sending email
        Log::useFiles(storage_path().'/logs/activation.log', 'info');
        Log::info('Email : '.$user->email);

        // Re set log path to store any erros information
        Log::useFiles(storage_path().'/logs/laravel.log', 'info');
            
        // Send Activation Email
        Mail::send('emails.activate_notification', ['user' => $user, 'url' => $url], 
            function ($message) use ($user) {
            $message->to($user->email, '')->subject("ETP Wallet - ETP Wallet Activation");
        });
    }
}
