<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;

class FirebaseController extends BaseController
{
    public function updateFCMToken(Request $request){

        $user=User::findOrFail(auth()->user()->id);
        $user->fcm_token=$request->fcm_token;
        $user->save();
        return $this->sendResponse(array(),"FCM token updated successfully", 200);
    }
}
