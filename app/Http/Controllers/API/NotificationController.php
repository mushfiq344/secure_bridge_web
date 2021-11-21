<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Notification;
use App\Models\Status;
use App\Models\Opportunity;
use App\Models\OpportunityUser;
use App\Models\WishList;

class NotificationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->user()->id)->get();
        $success['notifications'] = $notifications;
        return $this->sendResponse($success, 'notification fetched successfully.', 200);
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
        $notification = Notification::where('id', $id)->where('user_id', auth()->user()->id)->first();
      
        if (!empty($notification)) {
            $notification->status = Status::$notificationStatusValues['Seen'];
            $notification->save();

            if ($notification->notifiable_type == "opportunity") {

                $opportunity = Opportunity::where('id',$notification->notifiable_id)->with('createdBy')->first();
                $success["opportunity"] = $opportunity;
                $success['upload_path'] = Opportunity::$_uploadPath;
                return $this->sendResponse($success, 'opportunity fetched successfully.', 200);
                
            }
        }
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
