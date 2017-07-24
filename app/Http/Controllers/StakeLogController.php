<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\StakeLog;
use App\Stake;

use JWTAuth;
use stdClass;

class StakeLogController extends Controller
{
    public function getStakeLog(Request $request)
    {
    	$user = JWTAuth::parseToken()->authenticate();
    	$response = new stdClass();

    	try {
    		$stake = Stake::where('user_id', $user->id)->get();

    		$stakeLog = StakeLogs::where('stake_id', $stake->id)->get();

    		$respone->success = true;
    		$response->data = $stakeLog;
    	}
    	catch(ModelNotFoundException $e) {
    		$response->success = false;
    		$response->message = "Stake history not found!";
    	}

    	return response()->json($response);
    }
}
