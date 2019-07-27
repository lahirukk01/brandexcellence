<?php

namespace App\Http\Controllers;

use App\Auditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuditorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth:auditor');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auditor');
    }


    public function selfUpdatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string', 'min:3', 'max:15', 'alpha_num',],
            'password' => ['required', 'string', 'min:3', 'max:15', 'alpha_num', 'confirmed'],
        ]);

        $currentPassword = $request->input('current_password');

        if( ! Hash::check( $currentPassword, $user->password)) {
            return redirect()->back()->with('passwordError', 'Invalid current password');
        }

        $password = $request->input('password');

        $user->update([
            'password' => Hash::make($password)
        ]);

        return redirect('auditor')->with('status', 'Password updated successfully');
    }

    public function showInsidePasswordResetForm()
    {
        return view('auditor.reset_password');
    }
}
