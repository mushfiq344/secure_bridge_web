<?php

namespace App\Http\Controllers\OrgAdmin;
use App\Models\Opportunity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpportunityUser;
class OpportunityUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opportunityIds=Opportunity::where('created_by',auth()->user()->id)->pluck('id');
      
        $userOpportunities=OpportunityUser::whereIn('opportunity_id', $opportunityIds)->get();
        return view('org_admin.user_opportunities.index',compact('userOpportunities'));
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
       $userOpportunity=OpportunityUser::findOrFail($id);
     
       $opportynity=Opportunity::where('created_by',auth()->user()->id)->where('id',$userOpportunity->opportunity_id)->firstOrFail();
      
       $userOpportunity->status=$userOpportunity->status=$request->status;
       $userOpportunity->save();
       return redirect(route('org-admin.user-opportunities.index'));
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
