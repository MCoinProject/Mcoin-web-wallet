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

   
}
