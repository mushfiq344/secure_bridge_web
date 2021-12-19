<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\OpportunityUser;
use App\Models\Opportunity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Models\Status;

class OpportunityUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $opportunityUser=OpportunityUser::findOrFail($id);
        $opportunityUser->status=$request->updated_status;
        $opportunityUser->save();

        $opportunity=Opportunity::findOrFail($request->opportunity_id);
        if($opportunity->status==Opportunity::$opportunityStatusValues['Rewarding']){
            $totalUnRewardedopportunityUsers=OpportunityUser::where('opportunity_id',$request->opportunity_id)->where('status',Status::$userStatusValues['Participated'])->count();
            if($totalUnRewardedopportunityUsers==0){
                $opportunity->status=Opportunity::$opportunityStatusValues['Finished'];
                $opportunity->save();
            }
        }
        
        $user=User::findOrFail($request->user_id);

        $notification=new Notification();   
        $notification->user_id=$user->id;
        $notification->title=Status::$userStatusNames[$request->updated_status];
        $notification->message= "Admin ".Status::$userStatusNames[$request->updated_status]." your enrollment";
        $notification->notifiable_type="opportunity";
        $notification->notifiable_id=$opportunity->id;
        $notification->save();

        Notification::sendNotification([$user->fcm_token],$notification->title,$notification->message);

        return $this->sendResponse(array(), 'user status updated.', 200);
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
