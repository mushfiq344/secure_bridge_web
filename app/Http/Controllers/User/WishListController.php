<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Opportunity;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Http\Request;
use Response;

class WishListController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userWish = WishList::where('opportunity_id', $request->opportunity_id)
            ->where('user_id', auth()->user()->id)->first();
        if (empty($userWish)) {

            $wish = new WishList;

            $wish->user_id = auth()->user()->id;
            $wish->opportunity_id = $request->opportunity_id;
            $wish->status = "active";
            $wish->save();
            $opportunity=Opportunity::findOrFail($request->opportunity_id);
            $user=User::findOrFail($opportunity->created_by);
           
            $notification=new Notification();

            $notification->user_id=$opportunity->created_by;
            $notification->title="Added to wish list";
            $notification->message= auth()->user()->email." Added ".$opportunity->title." In with list";
            $notification->notifiable_type="opportunity";
            $notification->notifiable_id=$opportunity->id;
            $notification->save();

            Notification::sendNotification([$user->fcm_token],$notification->title,$notification->message);

        }
        return Response::json(["message" => 'added to wishlist successfully'], 201);
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
        WishList::where('opportunity_id', $id)->where('user_id', auth()->user()->id)->delete();
        return Response::json(["message" => 'removed from wish list successfully'], 200);
    }
}
