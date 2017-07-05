<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use stdClass;
use Validator;

use App\Transaction;
use App\User;

class DashboardController extends Controller
{
    public function getData()
    {
    	$transactions = Transaction::all();
    	$users = User::all();

    	///return data and display to the page
    	$page_settings = array(
    	    'transactions' => $transactions,
    	    'users' => $users
    	);

    	return view('pages.dashboard')->with($page_settings);
    }
}
