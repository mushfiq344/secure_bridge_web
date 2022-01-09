<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Models\PlanUser;
use App\Models\Profile;
use Exception;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
    
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
    
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $user->fcm_token = $request->fcm_token;
            $user->save();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['user'] = array(
                "name" => $user->name,
                "email" => $user->email,
                "id" => $user->id,
                "reg_completed" => $user->reg_completed,
                "user_type" => $user->user_type,
                "profile_image" => User::getUserPhoto($user->id),
                "has_create_opportunity_permission" => false,
                "profile"=>$user->profile
            );
    
            return $this->sendResponse($success, 'User register successfully.', 201);
        }catch (\Exception $e) {
          
            return $this->sendError('Validation Error.',[$validator->errors()]);
           
        }

    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if(!$user->is_active){
                return $this->sendError('You Account has been inactivated', ['error' => 'Unauthorised'],403);
            }
            $user->fcm_token = $request->fcm_token;
            $user->save();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $profile = Profile::where('user_id',$user->id)->first();
            $success['user'] = array(
                "name" => empty($profile)?$user->name:$profile->full_name, "email" => $user->email, "id" => $user->id,
                "user_type" => $user->user_type,
                "reg_completed" => $user->reg_completed,
                "fcm_token" => $request->fcm_token,
                "profile_image" => User::getUserPhoto($user->id),
                "has_create_opportunity_permission" => PlanUser::where('user_id', auth()->user()->id)->where('plan_id', 2)->where('end_date', '>', date('Y-m-d'))->exists(),
                "profile"=>$user->profile
            );

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->sendResponse([], 'Logged Out Successfully.');
    }


    public function requestTokenGoogle(Request $request)
    {
        // Getting the user from socialite using token from google
        $token = $request->google_token;
        $provider = 'google';
        $driver = Socialite::driver($provider);
        $userGoogleInfo = $driver->userFromToken($token);
        // Getting or creating user from db
        $user = User::firstOrCreate(
            ['email' => $userGoogleInfo->getEmail()],
            [
                'email_verified_at' => now(),
                'name' => $userGoogleInfo->name,
                'password' => bcrypt('123456')
            ]
        );

        if(!$user->is_active){
            return $this->sendError('You Account has been inactivated', ['error' => 'Unauthorised'],403);
        }


        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $profile = Profile::where('user_id',$user->id)->first();
        $success['user'] = array(
            "name" => empty($profile)?$user->name:$profile->full_name, "email" => $user->email, "id" => $user->id, "user_type" => $user->user_type, "profile_image" => User::getUserPhoto($user->id),
            "reg_completed" => $user->reg_completed,
            "has_create_opportunity_permission" => PlanUser::where('user_id', $user->id)->where('plan_id', 2)->where('end_date', '>', date('Y-m-d'))->exists(),
            "profile"=>$user->profile
        );
        return $this->sendResponse($success, 'User login successfully.');


        // // Returning response
        // $token = $userFromDb->createToken('Laravel Sanctum Client')->plainTextToken;
        // $response = ['token' => $token, 'message' => 'Google Login/Signup Successful'];
        // return response($response, 200);


    }

    public function completeRegistration(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);

        if(!$user->is_active){
            return $this->sendError('You Account has been inactivated', ['error' => 'Unauthorised'],403);
        }
        if ($user->reg_completed == 0) {
            $user->user_type = $request->selected_type;
            $user->reg_completed = 1;
            $user->save();
            $success['user'] = array(
                "name" => $user->name, "email" => $user->email, "id" => $user->id, "user_type" => $user->user_type, "profile_image" => User::getUserPhoto($user->id),
                "reg_completed" => $user->reg_completed,
                "has_create_opportunity_permission" => PlanUser::where('user_id', auth()->user()->id)->where('plan_id', 2)->where('end_date', '>', date('Y-m-d'))->exists(),
                "profile"=>$user->profile
            );
            return $this->sendResponse($success, 'User type selected successfully.');
        } else {
            if ($user->user_type == 1) {
                if ($user->reg_completed <2) {

                    $user->reg_completed = 2;
                    $user->save();
                    $success['user'] = array(
                        "name" => $user->name, "email" => $user->email, "id" => $user->id, "user_type" => $user->user_type, "profile_image" => User::getUserPhoto($user->id),
                        "reg_completed" => $user->reg_completed,
                        "has_create_opportunity_permission" => PlanUser::where('user_id', auth()->user()->id)->where('plan_id', 2)->where('end_date', '>', date('Y-m-d'))->exists(),
                        "profile"=>$user->profile
                    );
                    return $this->sendResponse($success, 'Organization admin initial package  selected successfully.');
                } else {
                    return $this->sendError('You can not change anymore1 .', [], 403);
                }
            } else {
                return $this->sendError('You can not change anymore.', [], 403);
            }
        }
    }
}
