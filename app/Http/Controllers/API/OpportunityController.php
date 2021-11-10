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

        $success['opportunities'] = Opportunity::all();
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
        $coverImage = $request->cover_image;
        $coverImageName = CustomHelper::saveBase64Image($coverImage, Opportunity::$_uploadPath, 300, 200);
        $iconImage = $request->icon_image;
        $iconImageName = CustomHelper::saveBase64Image($iconImage, Opportunity::$_uploadPath, 300, 200);
        $opportunity = new Opportunity;
        $opportunity->title = $request->title;
        $opportunity->created_by = auth()->user()->id;
        $opportunity->subtitle = $request->subtitle;
        $opportunity->description = $request->description;
        $opportunity->opportunity_date = $request->opportunity_date;
        $opportunity->duration = $request->duration;
        $opportunity->reward = $request->reward;
        $opportunity->type = $request->type;
        $opportunity->icon_image = $iconImageName;
        $opportunity->cover_image = $coverImageName;
        $opportunity->slug = CustomHelper::generateSlug($request->title, 'opportunities');
        $opportunity->save();
        $success = array(
            "opportunity" => $opportunity,
        );
        return $this->sendResponse($success, 'opportunity created successfully.', 201);
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
        $success['in_user_wish_list']=!empty($$userWish)?true:false;
        $success["enrollment_status"]=!empty($userOpportunity)?Status::$userStatusNames[$userOpportunity->status]:null;
        $success["user_code"]=!empty($userOpportunity)?$userOpportunity->code:null;
        $success["opportunity_users"]=$opportunity->users;
         
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
    {
        $opportunity = Opportunity::find($request->id);

        if ($request->cover_image) {
            // delete file
            $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->cover_image;
            if (file_exists($fileName)) {
                \File::delete($fileName);
            }

            $coverImageName = CustomHelper::saveBase64Image($request->cover_image, Opportunity::$_uploadPath, 1600, 900);
            $opportunity->cover_image = $coverImageName;
        }

        if ($request->icon_image) {
            // delete file
            $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->icon_image;
            if (file_exists($fileName)) {
                \File::delete($fileName);
            }

            $iconImageName = CustomHelper::saveBase64Image($request->icon_image, Opportunity::$_uploadPath, 600, 600);
            $opportunity->icon_image = $iconImageName;
        }

        $opportunity->title = $request->title;
        $opportunity->slug = CustomHelper::generateSlug($request->title, 'opportunities');
        $opportunity->subtitle = $request->subtitle;
        $opportunity->description = $request->description;
        $opportunity->opportunity_date = $request->opportunity_date;
        $opportunity->duration = $request->duration;
        $opportunity->reward = $request->reward;
        $opportunity->type = $request->type;

        $opportunity->save();
        $success = array(
            "opportunity" => $opportunity,
        );
        return $this->sendResponse($success, 'opportunity updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $opportunity = Opportunity::find($id);
        $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->cover_image;
        if (file_exists($fileName)) {
            \File::delete($fileName);
        }
        $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->icon_image;
        if (file_exists($fileName)) {
            \File::delete($fileName);
        }
        $opportunity = Opportunity::destroy($id);

        $success = array(
            "opportunity" => $opportunity,
        );
        return $this->sendResponse($success, 'opportunity deleted successfully.', 200);
    }

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