<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Get the DNC Price
Route::get('/dnc/price', 'DashboardController@getDNCPrice');

// Generate User's new Key Addresses
Route::get('/generate/key', 'KeyGenerator@generateKey');

// Get Dash API results
Route::group(['prefix'=>'dash'], function () {
	Route::get('/difficulty', 'DashController@getDifficulty');
	Route::get('/hash/rate', 'DashController@getHashRate');
	Route::get('/block/count', 'DashController@getBlockCount');
	Route::get('/account/{address}', 'DashController@getAccount');
	Route::get('/transaction/{hash}', 'DashController@getTransaction');
	Route::get('/info', 'DashController@getInfo');
});


// Register user
Route::post('/register', 'AccessController@registerUser');

// Return Token and user Details
Route::post('/login', 'AccessController@loginUser');

// Return total wallet balance
Route::get('/wallet/balance', function () {
	$user = JWTAuth::parseToken()->authenticate();
	$response = new stdClass();

	if(! $user) {
		$response->success = false;
		$response->message = "User token expired.";
	}
	else {
		$response->success = true;
		$response->walletBalance = $user->getTotalBalance();
	}

	return response()->json($response);
});

// Return user API
Route::group(['prefix'=>'profile' , 'middleware'=>'jwt'] , function () {
	// Return dashboard data for mobile
	Route::get('/dashboard', 'DashboardController@mobileDashboard');
	// Return user Profiles
	Route::get('/', 'AccessController@getUserProfile');
	// Upload profile picture
	Route::post('/picture', 'ProfileController@changeProfilePicture');
	// Update profile info
	Route::post('/update', 'ProfileController@updateBasicInfo');
});

// Return transactions
Route::group(['prefix'=>'transactions'], function () {
	// Return transaction histories
	Route::get('/transfer/histories', 'TransferAssetController@getTransactionHistories');
	// Return request histories
	Route::get('/request/histories', 'RequestController@getRequestHistories');
	// Return request
	Route::post('/request', 'RequestController@sendRequest');
	// Return transfer
	Route::post('/transfer', 'TransferAssetController@transferAset');
});