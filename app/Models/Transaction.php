<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public static $transactionTypesValues=array(
        "Subscription"=>"0"
    );

    public static $transactionStatusValues=array(
        "incomplete"=>"0",
        "complete"=>"1"
    );
}
