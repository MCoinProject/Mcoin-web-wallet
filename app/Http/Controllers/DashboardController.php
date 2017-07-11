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

    	$transfers = TransferAsset::orWhere('sender_address', $user->wallet->address)
        ->orWhere('receiver_address', $user->wallet->address)
        ->orderBy('created_at', 'desc')
        ->paginate(5);

    	///return data and display to the page
    	$page_settings = array(
    	    'transfers' => $transfers
    	);

    	return view('pages.dashboard')->with($page_settings);
    }   

    function get_web_page( $url )
    {
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

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }

    function get_dnc_ask_price()
    {
        $result = $this->get_web_page("https://nodejs.dinardirham.com:8488/rCeiDSZkp5XkcOdpSvOZCAimPZ7R3RgY/quotes/DNC_1DINAR");
        $resp = json_decode($result['content']);
        return response()->json($resp);
        // return ($resp->ask - ($resp->ask * 0.1));
    }
}
