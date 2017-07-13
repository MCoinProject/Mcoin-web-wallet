<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EasyDash;
use stdClass;
use Validator;

class DashController extends Controller
{
	protected $ip = "128.199.225.217";
	protected $port = "9998";
	protected $user = "sayed";
	protected $rpc_name = "fxbitlab_dash_test_RPC";

    public function getDifficulty($src = null)
    {
    	$response = new stdClass();

    	$etp = new EasyDash($this->user, $this->rpc_name, $this->ip, $this->port);
    	$difficulty = $etp->getdifficulty();

    	if($difficulty){
    		$response->success = true;
    		$response->data = $difficulty;
    	} else {
    		$response->success = false;
    		$response->data = null;
    	}
    	

    	if($src == 'web'){
    		return $response;
    	}

    	return response()->json($response);
    }

    public function getHashRate($src = null)
    {
    	$response = new stdClass();

    	$etp = new EasyDash($this->user, $this->rpc_name, $this->ip, $this->port);
    	$minInfo = $etp->getmininginfo();
    	$hashrate =  $minInfo['networkhashps'];
    	$hashrate_text = "";

    	if($hashrate){
    		$response->success = true;

    		if( $hashrate >= 1000000000000){
    			$hashrate_text = number_format($hashrate/1000000000000, 3)." TH/s";
    		}else if($hashrate >= 1000000000 ){
    			$hashrate_text = number_format($hashrate/1000000000, 3)." GH/s";
    		}else if( $hashrate >= 1000000 ){
    			$hashrate_text = number_format($hashrate/1000000, 3)." MH/s";
    		}else{
    			$hashrate_text = number_formatl($hashrate, 3)." H/s";
    		}
    	} else {
    		$response->success = false;
    		$response->data = null;
    	}

    	$response->data = $hashrate_text;

    	if($src == 'web'){
    		return $response;
    	}

    	return response()->json($response);
    }

    public function getBlockCount($src = null)
    {
    	$response = new stdClass();

    	$etp = new EasyDash($this->user, $this->rpc_name, $this->ip, $this->port);
    	$blockCount = $etp->getblockcount();

    	if($blockCount){
    		$response->success = true;
    		$response->data = $blockCount;
    	} else {
    		$response->success = false;
    		$response->data = 0;
    	}

    	if($src == 'web'){
    		return $response;
    	}

    	return response()->json($response);
    }

    public function getAccount($address, $src = null)
    {
    	$response = new stdClass();

    	if ($address == "") 
    	{
    	    $response->success = false;
    	    $response->data = "Invalid address";
    	} 
    	else 
    	{
	    	$etp = new EasyDash($this->user, $this->rpc_name, $this->ip, $this->port);
	    	$account = $etp->getaccount($address);

	    	if($account){
	    		$response->success = true;
	    		$response->data = $account;
	    	} else {
	    		$response->success = false;
	    		$response->data = null;
	    		$response->address = $address;
	    	}
	    }

	    if($src == 'web'){
	    	return $response;
	    }

    	return response()->json($response);
    }
}
