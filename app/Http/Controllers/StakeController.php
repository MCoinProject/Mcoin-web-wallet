<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Stake;

use stdClass;
use JWTAuth;

class StakeController extends Controller
{
	/*
	 *	Get stake history
	 */
    public function getStake()
    {
    	$user = JWTAuth::parseToken()->authenticate();
    	$response = new stdClass();

    	try {
    		$stake = Stake::where('user_id', $user->id)->first();

    		$response->success =  true;
    		$response->data = $stake;
    	}   
    	catch(ModelNotFoundException $e) {
    		$response->success = false;
    		$response->message = "Stake history not found!";
    	}

    	return response()->json($response);	
    }
}
