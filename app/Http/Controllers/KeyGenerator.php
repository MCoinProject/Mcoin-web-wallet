<?php

namespace App\Http\Controllers;

use Guzzle\Http\Exception\ConnectException;
use GuzzleHttp\Client;

use Exception;
use stdClass;

class KeyGenerator extends Controller
{
    /*
     *  Generate new key for user when user register the wallet
     */
    public function generateKey()
    {
        // Declare variable
    	$response = new stdClass();
    	$success = false;
    	$status = 0;

    	try {
    	    $client = new Client(); //GuzzleHttp\Client

            // Assign API request for new address result into variable
    	    $request = $client->request('POST', "https://api.blockcypher.com/v1/dash/main/addrs");

            // Get result content from guzzle request
    	    $result = json_decode($request->getBody(), true);

            // Get the status code of the request
    	    $status = $request->getStatusCode();
    	    $success = true;

    	} catch (ConnectException $e) {
    	    // Catch the guzzle connection errors over here. These errors are  
    	    // something like the connection failed or some other network error
    	    $result = json_encode((string)$e->getResponse()->getBody());
    	}

        // Return value to response variable
    	$response->success = $success;
    	$response->result = $result;
    	$response->status = $status;

    	// return response()->json($response);

    	return $response;
    }
}
