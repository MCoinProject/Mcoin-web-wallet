<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use stdClass;

class StakeLogController extends Controller
{
    public function getStakeProfit(Request $request)
    {
    	$user = JWTAuth::parseToken()->authenticate();
    }
}
