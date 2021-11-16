<?php

namespace App\Http\Controllers\API\User;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\WishList;
use App\Models\OpportunityUser;
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
        $enrolledOpportunityIds= OpportunityUser::where('user_id', auth()->user()->id)->pluck('opportunity_id')->toArray();
        $success['user_wishes'] = WishList::where('user_id', auth()->user()->id)->pluck('opportunity_id')->toArray();
        $success['user_enrollments'] = OpportunityUser::where('user_id', auth()->user()->id)->pluck('opportunity_id')->toArray();
        $success['opportunities']=Opportunity::whereIn('id', $enrolledOpportunityIds)->with('createdBy')->get();
        $success['upload_path'] = Opportunity::$_uploadPath;
        return $this->sendResponse($success, 'opportunities fetch successfully.', 200);
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
