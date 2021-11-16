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


    public static function  getUserCode($opportunityId)
    {
        $userOpportunity = self::where('opportunity_id', $opportunityId)->where('user_id', auth()->user()->id)->first();
        if ($userOpportunity) {
            return $userOpportunity->code;
        } else {
            return 0;
        }
    }

    public static function hasAnySpecificUserEnrolledOpportunity($opportunityId, $code)
    {
        $isEnrolled = self::where('opportunity_id', $opportunityId)->where('code', $code)->exists();

        return $isEnrolled;
    }

    public static function getEnrollmentStatus($userId, $opportunityId)
    {
        $userOpportunity = self::where('opportunity_id', $opportunityId)->where('user_id', $userId)->first();

        if (!empty($userOpportunity)) {
            return Status::$userStatusValues[$userOpportunity->status];
        }
    }
}
