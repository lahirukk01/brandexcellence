<?php

namespace App\Http\Controllers\Auth;

use App\Rules\AllowedToLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JudgeLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/judge';


    public function __construct()
    {
        $this->middleware('guest:admin');
        $this->middleware('guest:client');
        $this->middleware('guest:judge');
        $this->middleware('guest:auditor');
    }

    public function showLoginForm()
    {
        return view('auth.judge_login');
    }

    protected function guard()
    {
        return Auth::guard('judge');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required', 'string'],
            'password' => 'required|string|min:3|max:15',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if($user->allowed == false) {
            Auth::guard('judge')->logout();
            return redirect()->route('judge.login')->with('userBlocked', 'You have been blocked out');
        }

        $user->online_status = 'Online';
        $user->save();
    }

}
