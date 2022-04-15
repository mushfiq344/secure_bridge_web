<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OpportunityUser;
use App\Models\User;
use Illuminate\Http\Request;
use Response;
use App\Models\Opportunity;
use App\Models\Notification;
use App\Http\Controllers\API\BaseController as BaseController;
class OpportunityUserController extends BaseController
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

        $opportunityUser=OpportunityUser::where('opportunity_id',$request->opportunity_id)
        ->where('user_id',auth()->user()->id)->first();
        
        if(empty($opportunityUser)){
            $opportunityUser = new OpportunityUser;

            $opportunityUser->user_id = auth()->user()->id;
            $opportunityUser->opportunity_id = $request->opportunity_id;
            $opportunityUser->code = mt_rand(100000,999999);
            $opportunityUser->save();


            $opportunity=Opportunity::findOrFail($request->opportunity_id);
            $user=User::findOrFail($opportunity->created_by);
           
            $notification=new Notification();

            $notification->user_id=$opportunity->created_by;
            $notification->title="Enrollment in opportunity";
            $notification->message= auth()->user()->email." Enrolled in ".$opportunity->title;
            $notification->notifiable_type="opportunity";
            $notification->notifiable_id=$opportunity->id;
            $notification->save();

            Notification::sendNotification([$user->fcm_token],$notification->title,$notification->message);
            return $this->sendResponse( array(),'added to enrollment list successfully', 201);
        }else{
            return $this->sendError("User is already Enrolled");
        }
      
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
        return Response::json(["message" => 'removed from enrollment list successfully'], 200);
    }
}