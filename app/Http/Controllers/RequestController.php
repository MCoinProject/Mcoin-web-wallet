<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Wallet;
use App\RequestAsset;
// use App\User;
use App\Jobs\SendEmail;

use Validator;
use stdClass;

class RequestController extends Controller
{
    /*
     *	Request from web
     */
    public function webRequest(Request $request)
    {
    	
    }

    /*
     *	Process Request function
     */
    public function sendRequest(Request $request)
    {
    	$response = new stdClass();
    	$user = Auth::user();
        $success = false;

    	$errors = array();

    	// Validate data according to necessity
    	$validator = Validator::make($request->all(), [
    		// 'address' => 'required|max:255'
    		'amount' => 'required|numeric',
    		'email' => 'required|email',
    		'description' => 'max:255|nullable'
    	]);

    	if($validator->fails()) {
    		$message = $validator->errors();
    	} else {
    		// Create Request
    		$newRequest = RequestAsset::create([
                'user_id' => $user->id,
                'coin_id' => 3,
    			'amount' => $request->amount,
    			'email' => $request->email,
    			'description' => $request->description
    		]);

    		if($newRequest) {
    			$success = true;
    			$message = "Your request has been sent";

                dispatch(new SendEmail($user, $request->amount, null, null, $request->email, 'request'));
    		} else {
    			$message = "Your request failed to be sent";
    		}

            $response->success = $success;
            $response->message = $message;

    		return response()->json($response);
    	}
    }

    /*
     *	Request from API
     */
    public function APIRequest(Request $request)
    {
    	
    }
}
