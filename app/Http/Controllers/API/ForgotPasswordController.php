<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends BaseController
{
    public function forgot(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),422);
            // return response(['errors' => $validator->errors()->all()], 422);
        }
        $response =  Password::sendResetLink($input);
        if ($response == Password::RESET_LINK_SENT) {
        
            return $this->sendResponse(array(),"Mail send successfully", 200);
        } else {
            return $this->sendError("Email could not be sent to this email address");
         
        }
       
    }
}
