<?php

namespace App\Http\Controllers\API\OrgAdmin;
use App\SecureBridges\Helpers\CustomHelper;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\OpportunityUser;
use App\Models\WishList;
use Illuminate\Support\Collection;
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
        $success['opportunities'] = Opportunity::where('created_by', auth()->user()->id)->where('status',Opportunity::$opportunityStatusValues["Published"])->with('createdBy')->get();
        $success['upload_path'] = Opportunity::$_uploadPath;
        $success['total_reward'] = Opportunity::where('created_by', auth()->user()->id)->sum('reward');
        $adminOpportunityIds = Opportunity::where('created_by', auth()->user()->id)->pluck('id')->toArray();
        $totalEnrolledUsers = OpportunityUser::whereIn('opportunity_id', $adminOpportunityIds)->pluck('user_id')->toArray();
        $totalEnrolledUsers  = new Collection($totalEnrolledUsers);
        $success['total_enrolled_users']=count($totalEnrolledUsers->unique()); 
        $success['total_pending_approval']=OpportunityUser::whereIn('opportunity_id', $adminOpportunityIds)->where('status',Status::$userStatusValues["Requested"])->count();
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
        $coverImage = $request->cover_image;
        $coverImageName = CustomHelper::saveBase64Image($coverImage, Opportunity::$_uploadPath, 300, 200);
        $iconImage = $request->icon_image;
        $iconImageName = CustomHelper::saveBase64Image($iconImage, Opportunity::$_uploadPath, 300, 200);
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
        $success = array(
            "opportunity" => $opportunity,
        );
        return $this->sendResponse($success, 'opportunity created successfully.', 201);
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
        $opportunity = Opportunity::find($request->id);

        if ($request->cover_image) {
            // delete file
            $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->cover_image;
            if (file_exists($fileName)) {
                \File::delete($fileName);
            }

            $coverImageName = CustomHelper::saveBase64Image($request->cover_image, Opportunity::$_uploadPath, 1600, 900);
            $opportunity->cover_image = $coverImageName;
        }

        if ($request->icon_image) {
            // delete file
            $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->icon_image;
            if (file_exists($fileName)) {
                \File::delete($fileName);
            }

            $iconImageName = CustomHelper::saveBase64Image($request->icon_image, Opportunity::$_uploadPath, 600, 600);
            $opportunity->icon_image = $iconImageName;
        }

        $opportunity->title = $request->title;
        $opportunity->slug = CustomHelper::generateSlug($request->title, 'opportunities');
        $opportunity->subtitle = $request->subtitle;
        $opportunity->description = $request->description;
        $opportunity->opportunity_date = $request->opportunity_date;
        $opportunity->duration = $request->duration;
        $opportunity->reward = $request->reward;
        $opportunity->type = $request->type;
        $opportunity->status=$request->status;
        $opportunity->save();
        $success = array(
            "opportunity" => $opportunity,
        );
        return $this->sendResponse($success, 'opportunity updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $opportunity = Opportunity::find($id);
        $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->cover_image;
        if (file_exists($fileName)) {
            \File::delete($fileName);
        }
        $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->icon_image;
        if (file_exists($fileName)) {
            \File::delete($fileName);
        }
     
        OpportunityUser::where('opportunity_id', $id)->delete();
        WishList::where('opportunity_id', $id)->delete();
        Notification::where('notifiable_type','opportunity')->where('notifiable_id',$id)->delete();
        $opportunity = Opportunity::destroy($id);
        
        $success = array(
            "opportunity" => $opportunity,
        );
        return $this->sendResponse($success, 'opportunity deleted successfully.', 200);
    }
}
