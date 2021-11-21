<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public static $fcmPushUrl = 'https://fcm.googleapis.com/fcm/send';
    public static $SERVER_API_KEY = 'AAAAusPNnzI:APA91bG1CZ6Y0qaDeXpvRnxcfrgUrBk-5QPt-gAIhM6bPUh07-QE7IKIKC5g6D6_Iiu1bj3P8qOvR_8j47lOsr6Vr9BdTZTVZ0Pk3eQ2IIwn5cL9A1fSe1TrTddN5rn4aUq8p42I7hJbfMYYhA--dWPNfkYrtOOerg';


    public static function sendNotification($firebaseTokens,$title,$message)
    {
        //FCM API end-point

        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key

        $data = [
            "registration_ids" => $firebaseTokens,
            "notification" => [
                "title" => $title,
                "body" => $message,
            ]
        ];
        $dataString = json_encode($data);


        $headers = [
            'Authorization: key=' . self::$SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::$fcmPushUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

       
    }
}
