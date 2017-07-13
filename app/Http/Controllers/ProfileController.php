<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

use App\Profile;
use App\User;
use App\Activation;

use Validator;
use stdClass;

class ProfileController extends Controller
{
    /*
     *  Change user's profile picture in wallet
     */
    public function changeProfilePicture(Request $request)
    {
        $response = new stdClass();

        $validator = Validator::make($request->all(), [ 
            'profile_picture' => 'required|image', 
        ]);

        if ($validator->fails()) 
        {
            $response->success = false;
            $response->message = $validator->messages();
        } 
        else 
        {
            // If the image file is valid (format/download completion)
            if ($request->file('profile_picture')->isValid()) 
            {
                $user = Auth::user();

                // Check image path is exist
                if(!File::exists(storage_path('photos/profile_pictures'))) {
                    // Create new folder for image path with permission
                    File::makeDirectory(storage_path('photos/profile_pictures'), 0775, true);
                }

                // If user have uploaded profile picture
                if (!empty($user->profile->profile_picture))
                {
                    // If the current profile picture image exist in folder
                    if(File::exists(storage_path('photos/profile_pictures/'.$user->profile->profile_picture))) {
                        // Remove the image
                        File::Delete(storage_path('photos/profile_pictures/'.$user->profile->profile_picture));
                    }
                }

                // Create current date
                $now = Carbon::now();
                
                // Get the date timestamp
                $now = $now->timestamp; 

                // Keep the image file extension format (.png/.jpg)
                $file_extension = $request->file('profile_picture')->getClientOriginalExtension();

                // Create new name based on timestamp and file extension
                $file_name = $user->id."_".$now.".".$file_extension;

                // Get the image from request
                $image = $request->file('profile_picture');

                // Define path to store new image
                $path = storage_path('photos/profile_pictures/' . $file_name);

                // Resize new image and store in the path defined
                Image::make($image->getRealPath())->fit(240)->save($path);

                $args = array(
                    'profile_picture' => $file_name
                );

                // Query to update profile picture image name in db
                $update = Profile::where('user_id', $user->id)->update($args);

                if($update == 1)
                {
                    $response->success = true;
                    $response->message = "Profile picture updated.";
                }

            }
            else
            {
                $response->success = false;
                $response->message = "Invalid image.";
            }
        }

        return response()->json($response);
    }

    /*
     *  Update user's basic info in wallet
     */
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

        // Assign and return response value
    	$response->success = $success;
        $response->message = $message;

		return response()->json($response);
    }

    /*
     *  Activate User Email
     */
    public function userActivation(Request $request)
    {
        // Assign user's activation code into variable
        $activation = Activation::where('code', $request->act)->first();

        $res = 0;
        $message = "Invalid code!";

        // If user exist and not yet activated
        if($activation && $activation->status != 'active'){
            $res = Activation::where('id', $activation->id)->update(['status' => 'active']);
        } else {
            $res = 2;
        }

        if($res == 1){
            $message = "Your account have been successfully activated!";
        } else if ($res == 2) {
            $message = "Your account have already been activated";
        }

        // Return data and display to the page
        $page_settings = array(
            'message' => $message,
        );

        return view('results.transfer')->with($page_settings);
    }
}
