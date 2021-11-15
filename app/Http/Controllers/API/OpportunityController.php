<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Opportunity;
use App\Models\OpportunityUser;
use App\Models\Status;
use App\Models\WishList;
use App\SecureBridges\Helpers\CustomHelper;
use Illuminate\Http\Request;

class OpportunityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maxDuration = Opportunity::max('duration');
        $minDuration = Opportunity::min('duration');
        $maxReward = Opportunity::max('reward');
        $minReward = Opportunity::min('reward');
        $success['max_duration'] = $maxDuration;
        $success['min_duration'] = $minDuration;
        $success['max_reward'] = $maxReward;
        $success['min_reward'] = $minReward;

        $success['opportunities'] = Opportunity::with('createdBy')->get();
        $success['upload_path'] = Opportunity::$_uploadPath;
        $success['user_wishes'] = WishList::where('user_id', auth()->user()->id)->pluck('opportunity_id')->toArray();
        $success['user_enrollments'] = OpportunityUser::where('user_id', auth()->user()->id)->pluck('opportunity_id')->toArray();
        return $this->sendResponse($success, 'opportunities fetch successfully.', 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $userOpportunity=OpportunityUser::where('user_id',auth()->user()->id)->where('opportunity_id',$id)->first();
        $userWish=WishList::where('user_id',auth()->user()->id)->where('opportunity_id',$id)->first();
        $success["opportunity"] = $opportunity;
        
        $success["is_user_enrolled"]=!empty($userOpportunity)?true:false;
        $success['in_user_wish_list']=!empty($userWish)?true:false;
        $success["enrollment_status"]=!empty($userOpportunity)?Status::$userStatusNames[$userOpportunity->status]:null;
        $success["user_code"]=!empty($userOpportunity)?$userOpportunity->code:null;
        $success["opportunity_users"]=$opportunity->users;
        $success["opportunity_creator"]=$opportunity->createdBy;
         
        return $this->sendResponse($success, 'opportunity fetched successfully.', 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {    }

    public function fetchOpportunities(Request $request)
    {
        // $durationLow = $request->duration_low;
        // $durationHigh = $request->duration_high;
        // $rewardLow = $request->reward_low;
        // $rewardHigh = $request->reward_high;
        // $searchField = $request->search_field;
        // $opportunityDate = $request->opportunity_date;

        // $opportunities = Opportunity::searchByParams($durationLow, $durationHigh, $rewardLow, $rewardHigh, $searchField, $opportunityDate);
        // $success['opportunities']=$opportunities;
        $success['opportunities'] = Opportunity::where('is_active',0)->get();
        $success['upload_path'] = Opportunity::$_uploadPath;
        $success['user_wishes'] = WishList::where('user_id', auth()->user()->id)->pluck('opportunity_id')->toArray();
        return $this->sendResponse($success, 'opportunities fetched successfully.', 200);

    }

    public function fetchOpportunityUsers(Request $request)
    {
        $opportunity = Opportunity::findOrFail($request->id);
        $success = array(
          
            "opportunity_users"=>$opportunity->users
        );
        return $this->sendResponse($success, 'opportunity users fetched successfully.', 200);
        

    }

    public function fetchUserOpportunityRelatedInfo(Request $request)
    {
      
        $userOpportunity=OpportunityUser::where('user_id',$request->user_id)->where('opportunity_id',$request->opportunity_id)->first();
        $success["is_user_enrolled"]=!empty($userOpportunity)?true:false;
        $success["enrollment_status"]=!empty($userOpportunity)?Status::$userStatusNames[$userOpportunity->status]:null;
        $success["user_code"]=!empty($userOpportunity)?$userOpportunity->code:null;
       
         
        return $this->sendResponse($success, 'user opportunity related data fetched successfully.', 200);
        

    }

    public function checkEnrollment(Request $request)
    {
       
        $success = array(
          
            "user_is_enrolled"=> OpportunityUser::hasAnySpecificUserEnrolledOpportunity($request->opportunity_id,$request->code)
        );
        return $this->sendResponse($success, 'opportunity users fetched successfully.', 200);
        

    }
    

}