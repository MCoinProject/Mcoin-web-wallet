<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use stdClass;
use Validator;

use App\TransferAsset;
use App\Jobs\SendEmail;

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
            $code = str_random(20);
    		$newTransferAsset = TransferAsset::create([
    			'user_id' => $user->id,
    			'sender_address' => $user->wallet->address,
    			'receiver_address' => $request->address,
    			'amount' => $request->amount,
                'email' => $request->email,
                'code' => $code,
    			'status' => 'pending',
    		]);

    		if($newTransferAsset) {
    			$message = "A confirmation link was sent to your email. Please click on the link to proceed.";
    			$success = true;

                dispatch(new SendEmail($user, $request->amount, $request->address, $code, 'transfer'));

    		} else {
    			$message = "Transfer asset failed";
    			$success = false;
    		}
    		
    	}

    	$response->message = $message;
    	$response->success = $success;

    	return response()->json($response);
    }

    public function validateTransfer(Request $request)
    {
        $transfer = TransferAsset::where('code', $request->txn)->first();
        $res = 0;
        $message = "Invalid code!";
        $success = false;

        if($transfer && $transfer->status != 'success'){
            $res = TransferAsset::where('id', $transfer->id)->update(['status' => 'success']);
        } else {
            $res = 2;
        }

        if($res == 1){
            $success = true;
            $message = "Transfer successful!";
        } else if ($res == 2) {
            $message = "Transfer have been validated!";
        }

        ///return data and display to the page
        $page_settings = array(
            'success' => $success,
            'message' => $message,
        );

        return view('results.transfer')->with($page_settings);
    }
}
