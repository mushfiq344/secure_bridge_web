<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Investor;
use App\Models\FavoriteCompany;
use App\Models\Message;
use App\Models\MyTeam;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\UserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;
use App\Models\CompanyOwner;
use App\Models\Company;
use App\Models\CompanyHistory;
use App\Models\CompanyContact;
use App\Models\CompanyNumber;
use App\Models\CompanyLeader;
use App\Models\CompanyPitch;
use App\Models\Organization;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $userTypeNames = User::getTypeNames();
        return view('admin.user.index', compact('users', 'userTypeNames'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|unique:users|max:255',
            'password' => 'required|max:255',

        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->input('password'));
        $user->save();


        return redirect(route('users.index'))->with('success', 'Saved');
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
        $userTypes = User::getTypes();

        $user = User::find($id);

        Message::where('from', $user->id)->delete();
        Message::where('to', $user->id)->delete();
        FavoriteCompany::where('user_id', $user->id)->delete();
        MyTeam::where('user_id', $user->id)->delete();
        Subscriber::where('email', $user->email)->delete();
        UserMail::where('user_id', $user->id)->delete();

        // startups
        $companyOwner = CompanyOwner::where('user_id', $user->id)->first();

        if (!empty($companyOwner)) {
            $companies = Company::where("owner_id", $companyOwner->id)->get();

            foreach ($companies as $company) {

                CompanyHistory::where('company_id', $company->id)->delete();
                CompanyContact::where('company_id', $company->id)->delete();
                CompanyNumber::where('company_id', $company->id)->delete();

                CompanyPitch::where('company_id', $company->id)->delete();
                $companyLeaders = CompanyLeader::where('company_id', $company->id)->get();
                foreach ($companyLeaders as $leader) {

                    $fileName = public_path() . '/' . CompanyLeader::$_uploadPath . $leader->logo;
                    if (file_exists($fileName)) \File::delete($fileName);
                }
                CompanyLeader::where('company_id', $company->id)->delete();
                FavoriteCompany::where('company_id', $company->id)->delete();
                MyTeam::where('company_id', $company->id)->delete();


                $fileName = public_path() . '/' . Company::$_uploadPath . $company->logo;
                if (file_exists($fileName)) \File::delete($fileName);
                $fileName = public_path() . '/' . Company::$_uploadPath . $company->cover;
                if (file_exists($fileName)) \File::delete($fileName);
                Company::where("owner_id", $companyOwner->id)->where('id', $company->id)->delete();
            }

            //delete company owner
            $fileName = public_path() . '/' . CompanyOwner::$_uploadPath . $companyOwner->photo;
            if (file_exists($fileName)) \File::delete($fileName);
            CompanyOwner::where('user_id', $user->id)->delete();
        }
        //investors
        $investor = \App\Models\Investor::where('user_id', $user->id)->first();

        if (!empty($investor)) {

            Organization::where('investor_id', $investor->id)->delete();

            $fileName = public_path() . '/' . \App\Models\Investor::$_uploadPath . $investor->photo;
            if (file_exists($fileName)) \File::delete($fileName);
            \App\Models\Investor::where('user_id', $user->id)->delete();
        }

        //mentors
        $mentor = \App\Models\Mentor::where('user_id', $user->id)->first();

        if (!empty($mentor)) {



            $fileName = public_path() . '/' . \App\Models\Mentor::$_uploadPath . $mentor->photo;
            if (file_exists($fileName)) \File::delete($fileName);
            \App\Models\Mentor::where('user_id', $user->id)->delete();
        }

        User::where('id', $user->id)->delete();


        return redirect(route('users.index'))->with('success', 'Deleted');
    }



    public function changeUserStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->is_active = $request->is_active;
        $user->save();
        return Response()->json([
            "success" => true,
            "leaders" => $request->all()
        ]);
    }
}
