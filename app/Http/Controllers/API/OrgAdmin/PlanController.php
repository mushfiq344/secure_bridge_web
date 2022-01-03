<?php

namespace App\Http\Controllers\API\OrgAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\PlanUser;

class PlanController extends OrgAdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $monthlyPlans=Plan::where('type',Plan::$planTypesValues['monthly'])->get();
            $yearlyPlans=Plan::where('type',Plan::$planTypesValues['yearly'])->get();
            $success['monthly_plans']= $monthlyPlans;
            $success['yearly_plans']= $yearlyPlans;
            $userActiveSubscribedPlans=PlanUser::where('user_id',auth()->user()->id)->where('end_date','>',date('Y-m-d'))->pluck('plan_id')->toArray();
            $success['user_subscribed_plans']=$userActiveSubscribedPlans;
            return $this->sendResponse($success, 'plans fetched successfully.', 200);
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
    public function show($id)
    {
        //
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
}
