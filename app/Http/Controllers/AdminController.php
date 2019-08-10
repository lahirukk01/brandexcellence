<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Auditor;
use App\Brand;
use App\Category;
use App\Flag;
use App\IndustryCategory;
use App\Judge;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $data['clients'] = User::count();
        $data['brands'] = Brand::count();
        $data['judges'] = Judge::count();
        $data['admins'] = Admin::count();
        $data['auditors'] = Auditor::count();
        $currentRound = Flag::whereId(1)->first()->current_round;
        return view('admin.dashboard', compact('data', 'currentRound'));
    }

    public function categories()
    {
        $categories = Category::all();

        return view('admin.show_categories', compact('categories'));
    }

    public function industryCategories()
    {
        $industryCategories = IndustryCategory::all();

        return view('admin.show_industry_categories', compact('industryCategories'));
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

        return redirect('admin')->with('status', 'Password updated successfully');
    }

    public function showInsidePasswordResetForm()
    {
        return view('admin.reset_password');
    }

}
