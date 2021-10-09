<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\SecureBridges\Helpers\CustomHelper;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);
        $profile = $user->profile;
        if ($profile) {
            return redirect(route('user.profiles.edit', ['profile' => $profile->id]));
        } else {
            return redirect(route('user.profiles.create'));

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photoName = CustomHelper::saveImage($request->file('photo')[0], Profile::$_uploadPath, 600, 600);

        $profile = new Profile;
        $profile->user_id = auth()->user()->id;
        $profile->full_name = $request->full_name;
        $profile->photo = $photoName;
        $profile->address = $request->address;
        $profile->gender = $request->gender;

        $profile->save();

        return redirect(route('user.home'))->with('success', 'saved');
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
        $profile = Profile::findOrFail($id);
        $uploadPath = Profile::$_uploadPath;
        // update only personal profile
        if ($profile->user_id == auth()->user()->id) {
            return view('user.profile.edit', compact('profile', 'uploadPath'));
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

        $profile = Profile::find($id)->first();

        if ($request->file('photo')) {
            // delete file
            $fileName = public_path() . '/' . User::$_uploadPath . $profile->photo;
            if (file_exists($fileName)) {
                \File::delete($fileName);
            }

            $photoName = CustomHelper::saveImage($request->file('photo')[0], User::$_uploadPath, 600, 600);
            $profile->photo = $photoName;
        }

        $profile->full_name = $request->full_name;

        $profile->address = $request->address;
        $profile->gender = $request->gender;

        $profile->save();

        return redirect(route('user.home'))->with('success', 'updated');
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