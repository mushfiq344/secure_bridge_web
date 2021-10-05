<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OpportunityUser;
use App\Models\User;
use Illuminate\Http\Request;
use Response;

class OpportunityUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        return $user->opportunities;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $opportunityUser = new OpportunityUser;

        $opportunityUser->user_id = auth()->user()->id;
        $opportunityUser->opportunity_id = $request->opportunity_id;
        $opportunityUser->status = "active";
        $opportunityUser->save();
        return Response::json([], 201);

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
        OpportunityUser::where('opportunity_id', $id)->where('user_id', auth()->user()->id)->delete();
        return Response::json(["data" => $id], 204);
    }
}