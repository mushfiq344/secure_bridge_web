<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;

class FirebaseController extends BaseController
{
    public function notification()
        {
            //FCM API end-point
            $url = 'https://fcm.googleapis.com/fcm/send';
            //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
            $SERVER_API_KEY = 'AAAAusPNnzI:APA91bG1CZ6Y0qaDeXpvRnxcfrgUrBk-5QPt-gAIhM6bPUh07-QE7IKIKC5g6D6_Iiu1bj3P8qOvR_8j47lOsr6Vr9BdTZTVZ0Pk3eQ2IIwn5cL9A1fSe1TrTddN5rn4aUq8p42I7hJbfMYYhA--dWPNfkYrtOOerg';
    
            $firebaseToken = ["djOuUStnTEybL37QAy0Cs3:APA91bG-hi5RbyBBAtaqtbBIYvZsd1PNtJmYQY-yiGZ3ZIxVmKk7L5sc6f7xqbVC9NOpTT85oAFROtim8Gjhys2G4BBgnYCwoh-zJA5ODwMV94gnVSmeGhSCM0JXHNYsm8fQ5eQ2J9_A"];
    
            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => "hello",
                    "body" => "hello you 2",
                ]
            ];
            $dataString = json_encode($data);
    
    
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    
            $response = curl_exec($ch);
    
            dd($response);
        }
}
