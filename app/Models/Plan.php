<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public static $planTypesNames=array(
        '0'=>'monthly',
        '1'=>'yearly'
    );
    public static $planTypesValues=array(
        'monthly'=>'0',
        'yearly'=>'1'
    );

    public static $planModesValues=array(
        'basic'=>'0',
        'pro'=>'1'
    );
}
