<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('site-register', 'Auth\AuthController@siteRegister');
Route::post('site-register', 'Auth\AuthController@siteRegisterPost');

Route::get('/home', function () {
	return redirect('/');
});

///return welcome page 
Route::get('/', function () {
	// if (Auth::check()) 
	// {
	//    return redirect('wallet');
	// }
	// else
	// {
	// 	return redirect('login');
	// }

	if (Auth::check() && (Auth::user()->getActivation()->status == 'active')) {
	   return redirect('wallet');
	} 
	else if (Auth::check() && (Auth::user()->getActivation()->status == 'inactive')) {
		Auth::logout();
		return redirect('login')->with('message', 'Please check your email for account activation link');
	}   
	else {
		return redirect('login');
	}    
});

/*
*	Upload Photo
*/
Route::get('photos/{filename}', function ($filename){
	if($filename == 'default_avatar.png') {
		return Image::make(public_path('/images/default_avatar.png'))->response();
	}else{
		return Image::make(storage_path('photos/profile_pictures/' . $filename))->response();
	}
});

Auth::routes();

/*
*	Validate Transfer Asset
*/
Route::get('/validate', 'TransferAssetController@validateTransfer');

/*
*	Activate Account Registration
*/
Route::get('/activation', 'ProfileController@userActivation');

///return admin page, where admin is the prefix to the route inside the group
Route::group(['middleware'=>'auth'] , function () {

	/*
	*	Dashboard view
	*/
	Route::get('/wallet', 'DashboardController@getData');
	
	/*
	* 	Transaction view
	*/
	Route::group(['prefix'=>'transactions', 'middleware'=>'auth'], function () {
		/* TRANSFER */
		Route::get('/transfer', function () {
			return view('pages.transfer');
		});
		Route::post('/transfer/add', 'TransferAssetController@transferAset');
		/* /TRANSFER */

		/* REQUEST */
		Route::get('/request', function () {
			return view('pages.request');
		});
		Route::post('/request/add', 'RequestController@sendRequest');
		/* /REQUEST */
	});

	/*
	*	Profile view
	*/
	Route::group(['prefix'=>'profile', 'middleware'=>'auth'], function () {
		Route::get('/', function () {
			return view('pages.profile');
		});
		Route::post('/update', 'ProfileController@updateBasicInfo');
		Route::post('/picture/update', 'ProfileController@changeProfilePicture');
	});

	/*
	*	Logout
	*/
	Route::get('/logout', function () {
		Auth::logout();
		return redirect('login');
	});
});

// Route::get('admin', function () {
//     return view('admin_template');
// });
