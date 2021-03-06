<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
          
            if (auth()->user()->user_type == 2) {
                return redirect()->route('admin.home');
            } else if (auth()->user()->user_type == 1) {
                return redirect()->route('org-admin.home');
            } else {
                return redirect()->route('user.home');
            }
        } else {
            return redirect()->route('login')
                ->with('error', 'Email-Address And Password Are Wrong.');
        }
    }

    public function showLoginForm(Request $request)
    {
        $email = $request->email;
        $redirectUrl = $request->redirect_url;
        $mobileView = $request->mobile_view;
        return view('auth.login', compact('email', 'redirectUrl', 'mobileView'));
    }

    public function showOrgAdminLoginForm()
    {
        return view('org_admin.auth.login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {

                $finduser->google_id
                    = $user->id;
                $finduser->save();

                Auth::login($finduser);

                if (auth()->user()->user_type == 2) {
                    return redirect()->route('admin.home');
                } else if (auth()->user()->user_type == 1) {
                    return redirect()->route('org-admin.home');
                } else {
                    return redirect()->route('user.home');
                }
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('123456dummy')
                ]);

                Auth::login($newUser);

                if (auth()->user()->user_type == 2) {
                    return redirect()->route('admin.home');
                } else if (auth()->user()->user_type == 1) {
                    return redirect()->route('org-admin.home');
                } else {
                    return redirect()->route('user.home');
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('facebook_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {
                $finduser->facebook_id
                    = $user->id;
                $finduser->save();
                Auth::login($finduser);

                if (auth()->user()->user_type == 2) {
                    return redirect()->route('admin.home');
                } else if (auth()->user()->user_type == 1) {
                    return redirect()->route('org-admin.home');
                } else {
                    return redirect()->route('user.home');
                }
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'password' => encrypt('123456dummy')
                ]);

                Auth::login($newUser);

                if (auth()->user()->user_type == 2) {
                    return redirect()->route('admin.home');
                } else if (auth()->user()->user_type == 1) {
                    return redirect()->route('org-admin.home');
                } else {
                    return redirect()->route('user.home');
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
