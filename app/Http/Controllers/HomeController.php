<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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

        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['string', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'designation' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'digits:10'],

            'company_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'vat_registration_number' => ['nullable', 'regex:/[0-9\-]{5,15}/i'],
            'ceo_name' => ['string', 'max:100'],
            'ceo_email' => ['string', 'email', 'max:100', 'unique:companies,ceo_email,' . $user->company->id],
            'ceo_contact_number' => ['required', 'string', 'digits:10'],
        ]);

        if($validation->fails()) {
            return redirect()->back()->with('errors', $validation->messages());
        }

        $userData['name'] = $data['name'];
        $userData['email'] = $data['email'];
        $userData['designation'] = $data['designation'];
        $userData['contact_number'] = $data['contact_number'];

        $user->update($userData);

        $companyData['name'] = $data['company_name'];
        $companyData['address'] = $data['address'];
        $companyData['vat_registration_number'] = $data['vat_registration_number'];
        $companyData['ceo_name'] = $data['ceo_name'];
        $companyData['ceo_email'] = $data['ceo_email'];
        $companyData['ceo_contact_number'] = $data['ceo_contact_number'];

        $user->company->update($companyData);

        return redirect()->route('client.index')->with('status', 'Profile updated successfully');
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

        return redirect('home')->with('status', 'Password updated successfully');
    }

    public function showInsidePasswordResetForm()
    {
        return view('client.reset_password');
    }

}
