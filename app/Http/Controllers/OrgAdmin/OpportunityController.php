<?php

namespace App\Http\Controllers\OrgAdmin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\SecureBridges\Helpers\CustomHelper;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maxDuration = Opportunity::max('duration');
        $minDuration = Opportunity::min('duration');
        $maxReward = Opportunity::max('reward');
        $minReward = Opportunity::min('reward');

        return view('org_admin.opportunity.index', compact('maxDuration', 'minDuration', 'maxReward', 'minReward'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('org_admin.opportunity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $iconImageName = CustomHelper::saveImage($request->file('icon_image')[0], Opportunity::$_uploadPath, 600, 600);
        $coverImageName = CustomHelper::saveImage($request->file('cover_image')[0], Opportunity::$_uploadPath, 1600, 900);
        $opportunity = new Opportunity;
        $opportunity->title = $request->title;
        $opportunity->created_by = auth()->user()->id;
        $opportunity->subtitle = $request->subtitle;
        $opportunity->description = $request->description;
        $opportunity->opportunity_date = $request->opportunity_date;
        $opportunity->duration = $request->duration;
        $opportunity->reward = $request->reward;
        $opportunity->location = $request->location;
        $opportunity->type = $request->type;
        $opportunity->icon_image = $iconImageName;
        $opportunity->cover_image = $coverImageName;
        $opportunity->slug = CustomHelper::generateSlug($request->title, 'opportunities');
        $opportunity->save();

        return redirect(route('org-admin.opportunities.index'))->with('success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $opportunity = Opportunity::where('id',$id)->where('created_by',auth()->user()->id)->firstOrFail();
        $uploadPath = Opportunity::$_uploadPath;
        return view('org_admin.opportunity.edit', compact('opportunity', 'uploadPath'));
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

        $opportunity = Opportunity::find($id)->first();

        if ($request->file('icon_image')) {
            // delete file
            $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->icon_image;
            if (file_exists($fileName)) {
                \File::delete($fileName);
            }

            $iconImageName = CustomHelper::saveImage($request->file('icon_image')[0], Opportunity::$_uploadPath, 600, 600);
            $opportunity->icon_image = $iconImageName;
        }

        if ($request->file('cover_image')) {
            // delete file
            $fileName = public_path() . '/' . Opportunity::$_uploadPath . $opportunity->cover_image;
            if (file_exists($fileName)) {
                \File::delete($fileName);
            }

            $coverImageName = CustomHelper::saveImage($request->file('cover_image')[0], Opportunity::$_uploadPath, 1600, 900);
            $opportunity->cover_image = $coverImageName;
        }

        $opportunity->title = $request->title;
        $opportunity->slug = CustomHelper::generateSlug($request->title, 'opportunities');
        $opportunity->subtitle = $request->subtitle;
        $opportunity->description = $request->description;
        $opportunity->opportunity_date = $request->opportunity_date;
        $opportunity->duration = $request->duration;
        $opportunity->reward = $request->reward;
        $opportunity->location = $request->location;
        $opportunity->type = $request->type;
        $opportunity->is_active=$request->is_active;

        $opportunity->save();
        return redirect(route('org-admin.opportunities.index'))->with('success', 'updated');
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