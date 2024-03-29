<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    // Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }




    // Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }

    // Github login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    // Github callback
    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->stateless()->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }


    //linkedin login
    public function redirectToLinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    //linkedin callback
    public function handleLinkedinCallback()
    {
        $user = Socialite::driver('linkedin')->stateless()->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }


    protected function _registerOrLoginUser($data)
    {
        //if user not found in database
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->provider_name = $data->getName();
            $user->email = $data->getEmail();
            $user->provider_id = $data->getId();
            $user->avatar = $data->getAvatar();
            $user->save();
        }

        //else login user
        Auth::login($user);
    }
}
