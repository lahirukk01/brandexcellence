<?php

namespace App\Http\Controllers\Auth;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Rules\AllowedToLogin;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required', 'string',],
            'password' => 'required|string',
        ]);
    }

    public function logout(Request $request)
    {
        if(Auth::guard('client')->check() && session('brands')) {
            $brands = session('brands');

            foreach ($brands as $b) {
                Brand::findOrFail($b->id)->delete();
            }
        }

        if(Auth::guard('judge')->check()) {
            $judge = Auth::guard('judge')->user();
            Cache::forget('judge_is_online' . $judge->id);
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        if($user->allowed == false) {
            Auth::guard('client')->logout();
            return redirect()->route('login')->with('userBlocked', 'You have been blocked out');
        }
    }
}
