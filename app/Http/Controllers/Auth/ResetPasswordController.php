<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use http\Env\Request;
use Illuminate\Http\Request;
//use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{

    public function index()
    {
        $roleName = Auth::user()->role->name;
        if($roleName == 'super' || $roleName == 'admin') {
            return view('admin.reset_password');
        } elseif ($roleName == 'judge') {
            return view('judge.reset_password');
        } else {
            return view('client.reset_password');
        }

    }

    public function update(Request $request)
    {
        $request->validate([
            '_token' => 'required',
            'current_password' => 'required|alpha_num|min:3|max:15',
            'password' => 'required|alpha_num|confirmed|min:3|max:15',

        ]);

        $currentPassword = $request->get('current_password');
        $newPassword = $request->get('password');

        $user = Auth::user();

        if(!Hash::check($currentPassword, $user->password)) {
            return redirect()->back()->with('status', 'Invalid current password');
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return redirect()->back()->with('status', 'Password reset successfully');
    }
}
