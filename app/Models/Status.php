<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    public static $userStatusNames=array(
        "0"=>"Requested",
        "1"=>"Approved",
        "2"=>"Rejected",
        "3"=>"Participated",
        "4"=>"Rewarded"
    );

    public static $userStatusValues=array(
        "Requested"=>"0",
        "Approved"=> "1",
        "Rejected"=>"2",
        "Participated"=>"3",
        "Rewarded"=>"4"
    );   


    public static $notificationStatusValues=array(
        "Unseen"=>"0",
        "Seen"=> "1"
    );  
}
