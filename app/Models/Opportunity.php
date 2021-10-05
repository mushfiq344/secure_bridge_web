<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;
    public static $_uploadPath = 'uploads/images/opportunities/';
    protected $table = "opportunities";

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function searchByParams($durationLow, $durationHigh, $rewardLow, $rewardHigh, $searchField, $opportunityDate)
    {
        $query = DB::table('opportunities')
            ->where('is_active', 1)->Where('title', 'like', '%' . $searchField . '%');

        $query = $query->whereBetween('duration', array($durationLow - 1, $durationHigh + 1));

        $query = $query->whereBetween('reward', array($rewardLow - 1, $rewardHigh + 1));

        if ($opportunityDate != null) {
            $query = $query->where('opportunity_date', $opportunityDate);
        };

        $opportunities = $query->paginate(1);

        return $opportunities;

    }

}