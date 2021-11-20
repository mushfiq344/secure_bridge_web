<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public static $fcmPushUrl = 'https://fcm.googleapis.com/fcm/send';
    public static $SERVER_API_KEY = 'AAAAusPNnzI:APA91bG1CZ6Y0qaDeXpvRnxcfrgUrBk-5QPt-gAIhM6bPUh07-QE7IKIKC5g6D6_Iiu1bj3P8qOvR_8j47lOsr6Vr9BdTZTVZ0Pk3eQ2IIwn5cL9A1fSe1TrTddN5rn4aUq8p42I7hJbfMYYhA--dWPNfkYrtOOerg';
}
