<?php

namespace App\Http\Controllers;

use Guzzle\Http\Exception\ConnectException;
use GuzzleHttp\Client;

use Exception;
use stdClass;

class KeyGenerator extends Controller
{
    public function generateKey()
    {
    	$response = new stdClass();
    	$success = false;
    	$status = 0;

    	try {
    	    $client = new Client(); //GuzzleHttp\Client
    	    $request = $client->request('POST', "https://api.blockcypher.com/v1/dash/main/addrs");

    	    $result = json_decode($request->getBody(), true);
    	    $status = $request->getStatusCode();
    	    $success = true;

    	} catch (ConnectException $e) {
    	    //Catch the guzzle connection errors over here.These errors are something 
    	    // like the connection failed or some other network error

    	    $result = json_encode((string)$e->getResponse()->getBody());
    	}

    	$response->success = $success;
    	$response->result = $result;
    	$response->status = $status;

    	// return response()->json($response);

    	return $response;
    }
}
