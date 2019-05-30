<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = Auth::user();
        return view('client.dashboard', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client)
    {
        $user = $client;
        return view('client.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $client)
    {
        $user = $client;
        $data = $request->all();

        if($data['email'] == $user->email) {
            unset($data['email']);
        }

        if($data['ceo_email'] == $user->company->ceo_email) {
            unset($data['ceo_email']);
        }

        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['string', 'email', 'max:100', 'unique:users'],
            'designation' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'digits:10'],

            'company_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'ceo_name' => ['string', 'max:100'],
            'ceo_email' => ['string', 'email', 'max:100', 'unique:companies'],
            'ceo_contact_number' => ['required', 'string', 'digits:10'],
        ]);

        if($validation->fails()) {
            return redirect()->back()->with('errors', $validation->messages());
        }

        $user->update($data);

        $data['name'] = $data['company_name'];
        $user->company->update($data);

        return redirect('client')->with('status', 'Profile updated successfully');
    }

    public function updatePassword(Request $request, User $client)
    {
        $user = $client;

        $request->validate([
            'old_password' => ['required', 'string', 'min:3', 'max:15', 'alpha_num',],
            'password' => ['required', 'string', 'min:3', 'max:15', 'alpha_num', 'confirmed'],
        ]);

        $currentPassword = $request->input('old_password');

        if( ! Hash::check( $currentPassword, $user->password)) {
            return redirect()->back()->with('passwordError', 'Invalid current password');
        }

        $password = $request->input('password');

        $user->update([
            'password' => Hash::make($password)
        ]);

        return redirect('client')->with('status', 'Password updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
