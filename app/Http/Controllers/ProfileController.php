<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Profile;
use App\User;
use Validator;
use stdClass;

class ProfileController extends Controller
{
    public function updateBasicInfo(Request $request)
    {
    	$response = new stdClass();
    	$user = Auth::user();
        $success = false;

    	// Validate data according to necessity
    	$validator = Validator::make($request->all(), [
    		'name' => 'required|max:255',
    		'phone_number' => 'required|numeric',
    	]);

    	if($validator->fails()) {
    		$message = $validator->errors();
    	} else {
    		$args = array(
    			'name' => $request->name,
    			'phone_number' => $request->phone_number,
    		);

    		$update = Profile::where('id', $user->id)->update($args);

    		if($update == 1) {
    			$success = true;
    			$message = 'Profile updated!';
    		} else {
    			$message = 'Profile failed to be updated!';
    		}
    	}

    	$response->success = $success;
        $response->message = $message;

		return response()->json($response);
    }
}
