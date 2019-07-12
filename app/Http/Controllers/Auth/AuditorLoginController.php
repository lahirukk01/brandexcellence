<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuditorLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/auditor';


    public function __construct()
    {
        $this->middleware('guest:admin');
        $this->middleware('guest:client');
        $this->middleware('guest:judge');
        $this->middleware('guest:auditor');
    }

    public function showLoginForm()
    {
        return view('auth.auditor_login');
    }

//    public function login(Request $request)
//    {
//        $request->validate([
//            'email' => 'required|email|max:50',
//            'password' => 'required|min:3|max:15',
//        ]);
//        return true;
//    }

    protected function guard()
    {
        return Auth::guard('auditor');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string|min:3|max:15',
        ]);
    }

}
