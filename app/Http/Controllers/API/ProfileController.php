<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\SecureBridges\Helpers\CustomHelper;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\PlanUser;

class ProfileController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);
        $profile = $user->profile;
        if ($profile) {
            return $this->sendResponse(array("profile" => $profile), 'profile retrieved successfully.', 200);
        } else {
            return $this->sendResponse(array("profile" => null), 'profile retrieved successfully.', 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profileExists = Profile::where('user_id', auth()->user()->id)->exists();
        if (!$profileExists) {
            $profileImage = $request->profile_image;
            $profileImageName = CustomHelper::saveBase64Image($profileImage, Profile::$_uploadPath, 300, 200);
            $profile = new Profile;
            $profile->user_id = auth()->user()->id;
            $profile->full_name = $request->full_name;
            $profile->photo = $profileImageName;
            $profile->address = $request->address;
            $profile->gender = $request->gender;

            $profile->save();
            $user = User::findOrFail(auth()->user()->id);
            $success['user'] = array(
                "name" => $user->name, "email" => $user->email, "id" => $user->id,
                "user_type" => $user->user_type,
                "reg_completed" => $user->reg_completed,
                "fcm_token" => $request->fcm_token,
                "profile_image" => User::getUserPhoto($user->id),
                "has_create_opportunity_permission" => PlanUser::where('user_id', auth()->user()->id)->where('plan_id', 2)->where('end_date', '>', date('Y-m-d'))->exists(),
                "profile" => $user->profile
            );
            return $this->sendResponse($success, 'profile created successfully.', 201);
        } else {
            return $this->sendError('You can not create profile again', [], 403);
        }
    }

    /**
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        if ($profile->user_id == auth()->user()->id) {
            if ($request->profile_image) {
                // delete file
                $fileName = public_path() . '/' . Profile::$_uploadPath . $profile->photo;
                if (file_exists($fileName)) {
                    \File::delete($fileName);
                }

                $profileImage = $request->profile_image;
                $profileImageName = CustomHelper::saveBase64Image($profileImage, Profile::$_uploadPath, 300, 200);
                $profile->photo = $profileImageName;
            }

            $profile->full_name = $request->full_name;

            $profile->address = $request->address;
            $profile->gender = $request->gender;

            $profile->save();

            $user = User::findOrFail(auth()->user()->id);
            $success['user'] = array(
                "name" => $user->name, "email" => $user->email, "id" => $user->id,
                "user_type" => $user->user_type,
                "reg_completed" => $user->reg_completed,
                "fcm_token" => $request->fcm_token,
                "profile_image" => User::getUserPhoto($user->id),
                "has_create_opportunity_permission" => PlanUser::where('user_id', auth()->user()->id)->where('plan_id', 2)->where('end_date', '>', date('Y-m-d'))->exists(),
                "profile" => $user->profile
            );
            return $this->sendResponse($success, 'profile uppdated successfully.', 200);
        }else{
            return $this->sendError('You can not change this profile',[], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
