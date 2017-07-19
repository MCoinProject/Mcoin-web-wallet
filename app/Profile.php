<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class Profile extends Model
{
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'profile_picture'
    ];

    public function getProfilePictureAttribute($value)
    {
        $url = url("/photos/default_avatar.png");

        if(!empty($value)) {
            // If the current profile picture image exist in folder
            if(File::exists(storage_path('photos/profile_pictures/'.$value))) {
                $url = url("/photos/".$value);
            }
        }

        return $url;
    }

}
