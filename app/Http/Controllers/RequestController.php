<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Wallet;
use App\RequestAsset;
// use App\User;

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
    	// $user = Auth::user();

    	$errors = array();

    	// Validate data according to necessity
    	$validator = Validator::make($request->all(), [
    		'amount' => 'required|max:255',
    		'email' => 'required|email|max:255',
    		'description' => 'max:255|nullable'
    	]);

    	if($validator->fails()) {
    		$message = $validator->errors();
    	} else {
    		// Create Request
    		$newRequest = RequestAsset::create([
    			'amount' => $request->amount,
    			'email' => $request->email,
    			'description' => $request->description
    		]);

    		if($newRequest) {
    			$success = true;
    			$response->data = $newRequest;
    		} else {
    			$response->message = $message;
    		}

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
