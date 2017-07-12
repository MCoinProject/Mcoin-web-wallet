<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;
use App\LoginHistory;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Custom Validation using recaptcha
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required', 
            'password' => 'required',
            'g-recaptcha-response'=>'required|captcha'
            // new rules here
        ]);
    }

    /**
     * This function will automatically called after successful login.
     * It will redirect to wallet page and store ip address in db
     *
     * @return void
     */
    protected function authenticated(Request $request, User $user){
       
        ///Stores ip address and last login value in array
        $args = array(
            'ip_address' => $request->getClientIp(true),
            'user_id' => $user->id
        );

        LoginHistory::create($args);

        return redirect('/');
        
    }
}
