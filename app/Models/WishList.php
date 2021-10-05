<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $table = "wish_list";
    use HasFactory;

    public static function hasListedOpportunity($opportunityId)
    {
        $isAdded = self::where('opportunity_id', $opportunityId)->where('user_id', auth()->user()->id)->exists();

        return $isAdded;

    }
}