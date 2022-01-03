<?php

namespace App\Http\Controllers\API\OrgAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\SecureBridges\Helpers\CustomHelper;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Models\Notification;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\OpportunityUser;
use App\Models\WishList;
use Illuminate\Support\Collection;

use App\Models\Tag;


class OpportunityFormController extends OrgAdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success['opportunities'] = Opportunity::where('created_by', auth()->user()->id)->with('createdBy')->orderBy('created_at','desc')->get();
        $success['upload_path'] = Opportunity::$_uploadPath;
        $success['total_reward'] = Opportunity::where('created_by', auth()->user()->id)->sum('reward');
        $adminOpportunityIds = Opportunity::where('created_by', auth()->user()->id)->pluck('id')->toArray();
        $totalEnrolledUsers = OpportunityUser::whereIn('opportunity_id', $adminOpportunityIds)->pluck('user_id')->toArray();
        $totalEnrolledUsers  = new Collection($totalEnrolledUsers);
        $success['total_enrolled_users']=count($totalEnrolledUsers->unique()); 
        $success['total_pending_approval']=OpportunityUser::whereIn('opportunity_id', $adminOpportunityIds)->where('status',Status::$userStatusValues["Requested"])->count();
        
        $success['engagement_data']=Opportunity::engagementData(auth()->user()->id);
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
        $coverImageName = CustomHelper::saveBase64Image($coverImage, Opportunity::$_uploadPath,1024, 576);
        $iconImage = $request->icon_image;
        $iconImageName = CustomHelper::saveBase64Image($iconImage, Opportunity::$_uploadPath, 512, 512);
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
        $opportunity->status=$request->status;
        $opportunity->location=$request->location;
       
        
        $opportunity->save();
     
        foreach($request->tag_values as $tag){
            $newTag=new Tag();
            $newTag->title=$tag;
            $newTag->opportunity_id=$opportunity->id;
            $newTag->save();
           
         }
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
        $opportunity = Opportunity::where('id',$id)->with(['createdBy','tags'])->firstOrFail();
        if($opportunity->created_by==auth()->user()->id){
            $success["opportunity"] = $opportunity;
            
            return $this->sendResponse($success, 'opportunity fetched successfully.', 200);
        }else{
            return $this->sendError('You dont have permission', [], 403);
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
        $opportunity = Opportunity::find($request->id);

        if ($request->cover_image) {
            // delete file
            $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->cover_image;
            if (file_exists($fileName)) {
                \File::delete($fileName);
            }

            $coverImageName = CustomHelper::saveBase64Image($request->cover_image, Opportunity::$_uploadPath, 1024, 576);
            $opportunity->cover_image = $coverImageName;
        }

        if ($request->icon_image) {
            // delete file
            $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->icon_image;
            if (file_exists($fileName)) {
                \File::delete($fileName);
            }

            $iconImageName = CustomHelper::saveBase64Image($request->icon_image, Opportunity::$_uploadPath, 512, 512);
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
        $opportunity->location=$request->location;
        $opportunity->save();
        Tag::where('opportunity_id', $request->id)->delete();
        foreach($request->tag_values as $tag){
            $newTag=new Tag();
            $newTag->title=$tag;
            $newTag->opportunity_id=$opportunity->id;
            $newTag->save();
           
         }
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
