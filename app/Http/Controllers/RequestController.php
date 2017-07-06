<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Wallet;
use App\Transaction;
use App\User;

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
    	$errors = array();
    	$success = false;

    	// Validate data according to necessity
    	$validator = Validator::make($request->all(), [
    		'amount' => 'required|max:255',
    		'email' => 'required|email|max:255',
    		'description' => 'max:255|nullable'
    	]);
    }

    /*
     *	Request from API
     */
    public function APIRequest(Request $request)
    {
    	
    }
}
