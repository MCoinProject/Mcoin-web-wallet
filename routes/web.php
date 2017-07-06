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

///return welcome page 
Route::get('/', function () {
	if (Auth::check()) 
	{
	   return redirect('wallet');
	}
	else
	{
		return redirect('login');
	}
    
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

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
		Route::get('/transfer', function () {
			return view('pages.transfer');
		});
		Route::get('/request', function () {
			return view('pages.request');
		});
	});

	/*
	*	Profile view
	*/
	Route::group(['prefix'=>'profile', 'middleware'=>'auth'], function () {
		Route::get('/', function () {
			return view('pages.profile');
		});
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
