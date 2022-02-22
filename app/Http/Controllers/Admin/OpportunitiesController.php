<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\Tag;
use App\SecureBridges\Helpers\CustomHelper;
use Illuminate\Http\Request;

class OpportunitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opportunities = Opportunity::all();
        return view('admin.opportunity.index', compact('opportunities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.opportunity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'icon_image'=>'required',
            'cover_image'=>'required'
         ]);
        $iconImageName = CustomHelper::saveImage($request->file('icon_image')[0], Opportunity::$_uploadPath, 600, 600);
        $coverImageName = CustomHelper::saveImage($request->file('cover_image')[0], Opportunity::$_uploadPath, 1600, 900);
        $opportunity = new Opportunity;
        $opportunity->title = $request->title;
        $opportunity->created_by = $request->user_id;
        $opportunity->subtitle = $request->subtitle;
        $opportunity->description = $request->description;
        $opportunity->opportunity_date = $request->opportunity_date;
        $opportunity->duration = $request->duration;
        $opportunity->reward = $request->reward;
        $opportunity->type = $request->type;
        $opportunity->icon_image = $iconImageName;
        $opportunity->cover_image = $coverImageName;
        $opportunity->slug = CustomHelper::generateSlug($request->title, 'opportunities');
        $opportunity->status = Opportunity::$opportunityStatusValues['Published'];
        $opportunity->location = $request->location;


        $opportunity->save();
        if ($request->tag_values != null) {
            foreach ($request->tag_values as $tag) {
                $newTag = new Tag();
                $newTag->title = $tag;
                $newTag->opportunity_id = $opportunity->id;
                $newTag->save();
            }
        }
        return redirect(route('admin.opportunities.index'))->with('success', 'Saved');
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
        
        $opportunity = Opportunity::findOrFail($id);
        $uploadPath = Opportunity::$_uploadPath;
        return view('admin.opportunity.edit', compact('opportunity','uploadPath'));
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
        $opportunity->created_by=$request->user_id;

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
        $opportunity->is_featured=$request->is_featured;

        $opportunity->save();
        return redirect(route('admin.opportunities.index'))->with('success', 'updated');
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

    public function changeOpportunityFeatureStatus(Request $request)
    {
        $opportunity = Opportunity::find($request->opportunity_id);
        $opportunity->is_featured = !$opportunity->is_featured;
        $opportunity->save();
        return Response()->json([
            "success" => true,
            "leaders" => $request->all()
        ]);
    }
}
