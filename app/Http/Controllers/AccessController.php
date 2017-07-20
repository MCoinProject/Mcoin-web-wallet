<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\KeyGenerator;

use stdClass;
use Validator;
use JWTAuth;

class AccessController extends Controller
{
	/**
     * Global variable declaration.
     *
     * @var string
     */
    protected $keyObj;

    /**
	 * Register User into the wallet
	 */
    public function registerUser(Request $request) {
    	$errors = array();
        $response = new stdClass();

        // Validate received data according to necessity
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|max:255',
            'password' => 'required|max:255',
            'confirm_password' => 'required|max:255|same:password'
        ]);

        // If fails, throws error message
        if ($validator->fails()) {
            $response->success = false;
            $response->message = $validator->errors();
        } else {
			// Insert new user into db
            $newUser = User::create([
                "username" => $request->username,
				"email" => $request->email,
				"password" => Hash::make($request->password),
				// "phone_number" => $request->phone_number
            ]);

            $regController = new RegisterController();
            $keygen = new KeyGenerator();
            $keyObj = $keygen->generateKey();

            $regController->createWallet($request, $newUser, $keyObj);

            $response = $this->authenticateUser($request->email, $request->password);
		}
        
        return response()->json($response);
    }

    /**
	 * Handle the user login
	 */
	public function loginUser(Request $request) {
		// Get the result of authenticateUser function
		$result = $this->authenticateUser($request->email, $request->password);

		return response()->json($result);
	}

	/**
	 * Handle the user token authentication
	 */
	public function authenticateUser($email, $password) {
        $response = new stdClass();

        try {
        	// Check the email validity
            if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $credentials = array('email'=>$email, 'password'=>$password);

                // If token is null
                if (! $token = JWTAuth::attempt($credentials)) {
                    $response->success = false;
                    $response->message = 'Invalid credentials.';
                } 
                else {
                    $response->success = true;
                }
            }
            // Check the username validity
            else if(!empty($email)) {
                $credentials = array('username'=>$email, 'password'=>$password);

                if (! $token = JWTAuth::attempt($credentials)) {
                    $response->success = false;
                    $response->message = 'Invalid credentials.';
                }
                else {
                    $response->success = true;
                }
            }

        } 
        catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            $response->success = false;
            $response->message = 'Cannot create token.';
        }

        if($response->success) {
            $user = $this->getUserDetails($email);

            $response->success = true;
            $response->token = $token;
            $response->user = $user;
        }

        return $response;
    }

	/**
	 * Get user detail
	 */
	public function getUserDetails($email) {
		$response = new stdClass();

		try {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    			$user = User::where('email', $email)->first();
            } else {
                $user = User::where('username', $email)->first();
            }
		}
         
        // If data is not found
		catch(ModelNotFoundException $e) {
			$response->success = false;
			$response->message = "User not found";
		}

		return $user;
	}

	/**
	 * Get user profile
	 */
	public function getUserProfile() {
		// Check if user token is valid
		$user = JWTAuth::parseToken()->authenticate();

		$response = new stdClass();

		try {
			$user = User::where('email', $user->email)->first();

            $response->success = true;
            $response->userData = $user;
		}
         
        // If data is not found
		catch(ModelNotFoundException $e) {
			$response->success = false;
			$response->message = "User not found";
		}

		return response()->json($response);
	}
}
