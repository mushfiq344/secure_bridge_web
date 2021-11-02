<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use App\SecureBridges\Helpers\CustomHelper;
use Image;
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
        $success['max_duration']=$maxDuration;
        $success['min_duration']=$minDuration;
        $success['max_reward']=$maxReward;
        $success['min_reward']=$minReward;
        return $this->sendResponse($success, 'opportunity data fetch successfully.',200);

        
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
        $coverImageName=CustomHelper::saveBase64Image($coverImage,Opportunity::$_uploadPath,300,200);
        $iconImage = $request->icon_image; 
        $iconImageName=CustomHelper::saveBase64Image($iconImage,Opportunity::$_uploadPath,300,200);
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
        $success=array(
         "opportunity"=> $opportunity
        );
        return $this->sendResponse($success, 'opportunity created successfully.',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $opportunity = Opportunity::where('slug', $slug)->first();
        return $opportunity->users;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
        $success['opportunities']=Opportunity::all();
        $success['upload_path'] = Opportunity::$_uploadPath;
        return $this->sendResponse($success, 'opportunities fetched successfully.',200);
       
    }

}