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
    public static $opportunityStatusNames=array(
        "0"=>"Drafted",
        "1"=>"Published",
        "2"=>"Currently Happening",
        "3"=>"Ended",
        "4"=>"Rewarding",
        "5"=>"Finished"
    );

    public static $opportunityStatusValues=array(
        "Drafted"=>0,
        "Published"=> 1,
        "Currently Happening"=>2,
        "Ended"=>3,
        "Rewarding"=>4,
        "Finished"=>5
    );   



    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchByParams($durationLow, $durationHigh, $rewardLow, $rewardHigh, $searchField, $opportunityDate)
    {
        $userTypes=User::getTypes();
        $query = DB::table('opportunities')->Where('title', 'like', '%' . $searchField . '%');

        if(auth()->user()->user_type==$userTypes['User']){
            $query = $query->where('is_active', 0);
        }
           

        $query = $query->whereBetween('duration', array($durationLow - 1, $durationHigh + 1));

        $query = $query->whereBetween('reward', array($rewardLow - 1, $rewardHigh + 1));

        if ($opportunityDate != null) {
            $query = $query->where('opportunity_date', $opportunityDate);
        };

       
        if(auth()->user()->user_type==$userTypes['Organizational Admin']){
            $query = $query->where('created_by', auth()->user()->id);
        }

        $opportunities = $query->paginate(1);

        return $opportunities;

    }

    public static function getOpportunityTitle($id){
        $opportunity=self::find($id);
        return $opportunity->title;
    }

    public static function engagementData($orgAdminUserId){
       $opportunityIds=Opportunity::where('created_by', auth()->user()->id)->pluck('id')->toArray();
       return $opportunityIds;
    }

    public function tags()
    {
        return $this->hasMany(Tag::class,'opportunity_id','id');
    }

}