<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Wallet;
use App\Profile;
use App\Activation;
use App\Jobs\ActivationEmail;
use App\LoginHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

use Illuminate\Container\Container;
use App\Http\Controllers\KeyGenerator;

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
    protected $keyObj;

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
    * Handle a registration request for the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $keygen = new KeyGenerator();
        $this->keyObj = $keygen->generateKey();

        if($this->keyObj->success && $this->keyObj->status == 201){

            $this->validator($request->all())->validate();
            event(new Registered($user = $this->create($request->all())));

            // Create Wallet credentials
            $this->createWallet($request, $user, $this->keyObj);

            $this->guard()->login($user);

            return $this->registered($request, $user)
                            ?: redirect($this->redirectPath());
        } else {
            return redirect('/login')->with('message', 'An error occured. Please submit a report and include this code [ERX: 001]');
        }
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'phone_number' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'g-recaptcha-response'=>'required|captcha'
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
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);        

        return $newUser;
    }

    /**
     * Create a new wallet address after creating user.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function createWallet($data, $userData, $keyObj)
    {
        $newWallet = Wallet::create([
            'user_id' => $userData->id,
            'address' => $keyObj->result['address'],
            'private_key' => $keyObj->result['private'],
            'public_key' => $keyObj->result['public'],
            'wif' => $keyObj->result['wif'],
        ]);

        $newProfile = Profile::create([
            'user_id' => $userData->id,
            'name' => $data->name,
            'phone_number' => $data->phone_number
        ]);

        $newActivation = Activation::create([
            'user_id' => $userData->id,
            'code' => str_random(20),
            // 'status' => 'inactive'
            'status' => 'active'
        ]);

        // // Stores ip address and last login value in array
        // $args = array(
        //     'ip_address' => \Request::ip(),
        //     'user_id' => $userData->id
        // );

        // LoginHistory::create($args);

        // Run Queue
        // dispatch(new ActivationEmail($userData));
    }
}
