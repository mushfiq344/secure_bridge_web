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
    public static $opportunityStatusNames = array(
        "0" => "Drafted",
        "1" => "Published",
        "2" => "Currently Happening",
        "3" => "Ended",
        "4" => "Rewarding",
        "5" => "Finished"
    );

    public static $opportunityStatusValues = array(
        "Drafted" => 0,
        "Published" => 1,
        "Currently Happening" => 2,
        "Ended" => 3,
        "Rewarding" => 4,
        "Finished" => 5
    );

    public static $opportunityTypes = [
        'Shelter',
        'Counselling',
        'Food',
        'Forms',
        'Jobs',
        'Health',
        'Mental health',
        'Therapy',
        'Mentorship',
        'Youth activities',
        'General resources(housing)'
    ];

    public static $opportunityTypesValues = [
        "Shelter" => 0,
        "Counselling" =>  1,
        "Food" =>  2,
        "Forms" =>  3,
        "Jobs" =>  4,
        "Health" =>  5,
        "Mental health" =>  6,
        "Therapy" =>  7,
        "Mentorship" =>  8,
        "Youth activities" => 9,
        "General resources(housing)" => 10
    ];



    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public static function searchByParams($durationLow, $durationHigh, $rewardLow, $rewardHigh, $searchField, $opportunityDate)
    {
        $userTypes = User::getTypes();
        $query = DB::table('opportunities')->Where('title', 'like', '%' . $searchField . '%');

        if (auth()->user()->user_type == $userTypes['User']) {
            $query = $query->where('is_active', 0);
        }


        $query = $query->whereBetween('duration', array($durationLow - 1, $durationHigh + 1));

        $query = $query->whereBetween('reward', array($rewardLow - 1, $rewardHigh + 1));

        if ($opportunityDate != null) {
            $query = $query->where('opportunity_date', $opportunityDate);
        };


        if (auth()->user()->user_type == $userTypes['Organizational Admin']) {
            $query = $query->where('created_by', auth()->user()->id);
        }

        $opportunities = $query->paginate(1);

        return $opportunities;
    }

    public static function getOpportunityTitle($id)
    {
        $opportunity = self::find($id);
        return $opportunity->title;
    }

    public static function engagementData($orgAdminUserId)
    {
        $opportunityIds = Opportunity::where('created_by', auth()->user()->id)->pluck('id')->toArray();

        //    return $opportunityUsers;
        if (date('l') == "Saturday") {
            $saturdayDate = date('Y-m-d');
        } else {
            $saturdayDate = date('Y-m-d', strtotime("last Saturday"));
        }

        if (date('l') == "Sunday") {
            $sundayDate = date('Y-m-d');
        } else {
            $sundayDate = date('Y-m-d', strtotime("last Sunday"));
        }

        if (date('l') == "Monday") {
            $mondayDate = date('Y-m-d');
        } else {
            $mondayDate = date('Y-m-d', strtotime("last Monday"));
        }
        if (date('l') == "Tuesday") {
            $tuesdayDate = date('Y-m-d');
        } else {
            $tuesdayDate = date('Y-m-d', strtotime("last Tuesday"));
        }

        if (date('l') == "Wednesday") {
            $wednesdayDate = date('Y-m-d');
        } else {
            $wednesdayDate = date('Y-m-d', strtotime("last Wednesday"));
        }

        if (date('l') == "Thursday") {
            $thursdayDate = date('Y-m-d');
        } else {
            $thursdayDate = date('Y-m-d', strtotime("last Thursday"));
        }

        if (date('l') == "Friday") {
            $fridayDate = date('Y-m-d');
        } else {
            $fridayDate = date('Y-m-d', strtotime("last Friday"));
        }

        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-7 days'));

        return [
            "start_date" => $startDate,
            "end_date" => $endDate,
            "day" => date('l'),
            "weekly_engagements" => [
                [
                    "day" => "Sat",
                    "date" => $saturdayDate,
                    "count" => DB::table('opportunity_user')->whereIn('opportunity_id', $opportunityIds)->whereDate("created_at", $saturdayDate)->count()
                ],
                [
                    "day" => "Sun",
                    "date" => $sundayDate,
                    "count" => DB::table('opportunity_user')->whereIn('opportunity_id', $opportunityIds)->whereDate("created_at", $sundayDate)->count()
                ],
                [
                    "day" => "Mon",
                    "date" => $mondayDate,
                    "count" => DB::table('opportunity_user')->whereIn('opportunity_id', $opportunityIds)->whereDate("created_at", $mondayDate)->count()
                ],
                [
                    "day" => "Tues",
                    "date" => $tuesdayDate,
                    "count" => DB::table('opportunity_user')->whereIn('opportunity_id', $opportunityIds)->whereDate("created_at", $tuesdayDate)->count()
                ],
                [
                    "day" => "Wed",
                    "date" => $wednesdayDate,
                    "count" => DB::table('opportunity_user')->whereIn('opportunity_id', $opportunityIds)->whereDate("created_at", $wednesdayDate)->count()
                ],
                [
                    "day" => "Thurs",
                    "date" => $thursdayDate,
                    "count" => DB::table('opportunity_user')->whereIn('opportunity_id', $opportunityIds)->whereDate("created_at", $thursdayDate)->count()
                ],
                [
                    "day" => "Fri",
                    "date" => $fridayDate,
                    "count" => DB::table('opportunity_user')->whereIn('opportunity_id', $opportunityIds)->whereDate("created_at", $fridayDate)->count()
                ]

            ]
        ];
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'opportunity_id', 'id');
    }
}
