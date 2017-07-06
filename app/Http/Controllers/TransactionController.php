<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use stdClass;
use Validator;

use App\Transaction;

class TransactionController extends Controller
{
    public function transferAset(Request $request)
    {
    	$response = new stdClass();
    	$user = Auth::user();

    	///validate received data according to necessity
    	$validator = Validator::make($request->all(), [ 
    	    'receiver_address' => 'required|max:255',
    	    'amount' => 'required|numeric|min:0.001',
    	    'email' => 'required|email',
    	]);

    	///if fails, throws error message
    	if ($validator->fails()) 
    	{
    	    $message = $validator->errors();
    	    $success = false;
    	} 
    	else 
    	{
    		$newTransaction = Transaction::create([
    			'sender_address' => $user->wallet->public_key,
    			'receiver_address' => $request->receiver_address,
    			'amount' => $request->amount,
    			'email' => $request->email,
    		]);

    		if($newTransaction) {
    			$message = $request->amount." was sent to ".$request->receiver_address;
    			$success = true;
    		} else {
    			$message = "Transaction failed";
    			$success = false;
    		}
    		
    	}

    	$response->message = $message;
    	$response->success = $success;
    	
    	return response()->json($response);
    }
}
