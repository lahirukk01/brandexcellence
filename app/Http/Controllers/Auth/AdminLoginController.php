<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';


    public function __construct()
    {
        $this->middleware('guest:admin');
        $this->middleware('guest:client');
        $this->middleware('guest:judge');
        $this->middleware('guest:auditor');
    }

    public function showLoginForm()
    {
        return view('auth.admin_login');
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
        return Auth::guard('admin');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string|min:3|max:15',
        ]);
    }

}
