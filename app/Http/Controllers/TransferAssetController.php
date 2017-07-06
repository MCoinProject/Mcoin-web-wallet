<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use stdClass;
use Validator;

use App\TransferAsset;

class TransferAssetController extends Controller
{
    public function transferAset(Request $request)
    {
    	$response = new stdClass();
    	$user = Auth::user();

    	///validate received data according to necessity
    	$validator = Validator::make($request->all(), [ 
    	    'address' => 'required|max:255',
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
    		$newTransferAsset = TransferAsset::create([
    			'user_id' => $user->id,
    			'sender_address' => $user->wallet->address,
    			'receiver_address' => $request->address,
    			'amount' => $request->amount,
    			'email' => $request->email,
    		]);

    		if($newTransferAsset) {
    			$message = $request->amount." DNC was sent to ".$request->address;
    			$success = true;
    		} else {
    			$message = "TransferAsset failed";
    			$success = false;
    		}
    		
    	}

    	$response->message = $message;
    	$response->success = $success;

    	return response()->json($response);
    }
}
