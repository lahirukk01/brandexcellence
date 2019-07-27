<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Mail\AdminRegistered;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SuAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::whereIsSuper(0)->get();

        return view('super.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:50|email|unique:admins',
            'contact_number' => 'required|digits:10',
            'designation' => 'required|max:100',
            'password' => 'required|alpha_num|min:3|max:15|confirmed',
        ]);

        $data = $request->all();

        $admin = new Admin([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'designation' => $data['designation'],
            'password' => Hash::make($data['password']),
            'is_super' => 0,
        ]);

        $admin->save();

        Mail::to($admin->email)->send(new AdminRegistered($data));
        return redirect()->route('super.admin.index')->with('status', 'Administrator created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('super.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $data = $request->all();

        $validation = Validator::make($data, [
            'name' => 'required|max:100',
            'email' => 'email|max:50|unique:admins,email,' . $admin->id,
            'contact_number' => 'required|digits:10',
            'designation' => 'required|max:100',
        ]);

        if($validation->fails()) {
            return redirect()->back()->with('errors', $validation->messages());
        }

        $admin->update($data);

        return redirect()->route('super.admin.index')->with('status', 'Administrator updated successfully');

    }


    public function updatePassword(Request $request, Admin $admin)
    {
        $request->validate([
            'password' => 'required|min:3|max:15|alpha_num|confirmed',
        ]);

        $password = $request->input('password');

        $admin->update([
            'password' => Hash::make($password)
        ]);

        return redirect()->route('super.admin.index')->with('status', 'Admin password updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('super.admin.index')->with('status', 'Administrator delete successfully');
    }
}
