<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Http\Request;

class OpportunityController extends Controller
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

        return view('user.opportunity.opportunity-list-for-users', compact('maxDuration', 'minDuration', 'maxReward', 'minReward'));
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
        //
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
        $durationLow = $request->duration_low;
        $durationHigh = $request->duration_high;
        $rewardLow = $request->reward_low;
        $rewardHigh = $request->reward_high;
        $searchField = $request->search_field;
        $opportunityDate = $request->opportunity_date;

        $opportunities = Opportunity::searchByParams($durationLow, $durationHigh, $rewardLow, $rewardHigh, $searchField, $opportunityDate);

        $uploadPath = Opportunity::$_uploadPath;
        return view('user.opportunity.opportunity-card', compact('opportunities', 'uploadPath'))->render();
    }

}