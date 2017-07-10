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
use Validator;
use stdClass;

class ProfileController extends Controller
{
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
            if ($request->file('profile_picture')->isValid()) 
            {
                $user = Auth::user();

                if(!File::exists(storage_path('photos/profile_pictures'))) {
                    File::makeDirectory(storage_path('photos/profile_pictures'), 0775, true);
                }

                if (!empty($user->profile->profile_picture))
                {
                    if(File::exists(storage_path('photos/profile_pictures/'.$user->profile->profile_picture))) {
                        File::Delete(storage_path('photos/profile_pictures/'.$user->profile->profile_picture));
                    }
                }

                $now = Carbon::now();
                $now = $now->timestamp; 
                $file_name_ori = $request->file('profile_picture')->getClientOriginalName();
                $file_extension = $request->file('profile_picture')->getClientOriginalExtension();
                $file_name = $user->id."_".$now.".".$file_extension;

                $image = $request->file('profile_picture');
                $path = storage_path('photos/profile_pictures/' . $file_name);

                Image::make($image->getRealPath())->fit(240)->save($path);

                $args = array(
                    'profile_picture' => $file_name
                );

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
