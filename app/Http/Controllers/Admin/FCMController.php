<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FCMController extends Controller
{


    public  function sendTo()
    {
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $SERVER_API_KEY = 'AAAACwFOnz8:APA91bHIpBv-krPZcADEXO7kCQakQBz0-XzwUtmswRZz93ZE-pJd_9oiEO7rHZqVLBR27VEQKpj94MMJ7EFgVaxWIqMCJlsa2X03LCPWHaNQq9xVN2YZJbJpMF9f6NbGKQF6SM6rkwEml0msvEEme6TrVtgJ39gJeg';

        $firebaseToken = ["dYboP9m4JZODFvpcR7VGkK:APA91bFPjt__3zz6oUGltgrReFINChKsHQMPDBnxHNmp6_prbhal_5XucJCLdJR1mIh-78AzAef8egnw2QK9Tz2jPLKO2nA7o07JcPKydFYF3vLU3Rs2CpU578aKtwnSplSotjVA3bHo"];

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "hello",
                "body" => "hello you",
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
