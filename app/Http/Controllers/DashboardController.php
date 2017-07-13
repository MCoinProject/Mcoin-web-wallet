<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use stdClass;
use Validator;

use App\TransferAsset;
use App\User;

class DashboardController extends Controller
{   
    /*
     *  Get data to be displayed in wallet page
     */
    public function getData()
    {
        $user =  Auth::user();

        // Query the data from db to be displayed into table pagination of 5
    	$transfers = TransferAsset::orWhere('sender_address', $user->wallet->address)
        ->orWhere('receiver_address', $user->wallet->address)
        ->orderBy('created_at', 'desc')
        ->paginate(5);

    	// Return data and display to the page
    	$page_settings = array(
    	    'transfers' => $transfers,
            'dnc_price' => $this->getDNCPrice()
    	);

    	return view('pages.dashboard')->with($page_settings);
    }   

    /*
     * 	Request DNC to be displayed
     */
    function dncRequest( $url )
    {
        // Declare parameter value
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        );

        // Declare cURL request
        $ch      = curl_init( $url );           // instantiate the instantce of cURL
        curl_setopt_array( $ch, $options );     // set curl setting
        $content = curl_exec( $ch );            // execute cURL request
        $err     = curl_errno( $ch );           // return cURL error number
        $errmsg  = curl_error( $ch );           // returns a string error message
        $header  = curl_getinfo( $ch );         // get information regarding a specific transfer
        curl_close( $ch );                      // close cURL request

        // Return header's value results
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }

    /*
     *	Get the DNC Price to be displayed
     */
    function getDNCPrice()
    {
        // Assign node js API request for DNC Price result into variable
        $result = $this->dncRequest("https://nodejs.dinardirham.com:8488/rCeiDSZkp5XkcOdpSvOZCAimPZ7R3RgY/quotes/DNC_1DINAR");

        // Decode the result of the content to be returned
        $resp = json_decode($result['content']);

        // If result content, return result to display
        if(isset($resp->ask)) {
            // return response()->json($resp);
            return ($resp->ask - ($resp->ask * 0.1));
        }
        return 0;
    }
}
