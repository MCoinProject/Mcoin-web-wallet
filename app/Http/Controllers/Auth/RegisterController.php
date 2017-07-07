<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Wallet;
use App\Profile;
use App\LoginHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $newUser = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $newWallet = Wallet::create([
            'user_id' => $newUser->id,
            'address' => $data['address'],
            'private_key' => $data['private_key'],
            'public_key' => $data['public_key']
        ]);

        $newProfile = Profile::create([
            'user_id' => $newUser->id,
            'name' => $data['name'],
            'phone_number' => $data['phone_number']
        ]);

        ///Stores ip address and last login value in array
        $args = array(
            'ip_address' => \Request::ip(),
            'user_id' => $newUser->id
        );

        LoginHistory::create($args);

        return $newUser;
    }
}
