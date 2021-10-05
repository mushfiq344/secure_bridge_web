<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunityUser extends Model
{
    protected $table = "opportunity_user";
    use HasFactory;

    public static function hasUserEnrolledOpportunity($opportunityId)
    {
        $isEnrolled = self::where('opportunity_id', $opportunityId)->where('user_id', auth()->user()->id)->exists();

        return $isEnrolled;

    }

}