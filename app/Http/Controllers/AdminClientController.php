<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = User::where('role_id', 4)->get();

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $client
     * @return \Illuminate\Http\Response
     */
    public function show(User $client)
    {
        return view('admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $client)
    {
        $data = $request->all();

        if($data['email'] == $client->email) {
            unset($data['email']);
        }

        if($data['ceo_email'] == $client->company->ceo_email) {
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

        $client->update($data);

        $data['name'] = $data['company_name'];
        $client->company->update($data);

        return redirect()->route('clients.index')->with('status', 'Profile updated successfully');
    }

    public function updatePassword(Request $request, User $client)
    {

        $request->validate([
            'password' => 'required|min:3|max:15|alpha_num|confirmed',
        ]);

        $password = $request->input('password');

        $client->update([
            'password' => Hash::make($password)
        ]);

        return redirect()->route('clients.index')->with('status', 'Client password updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $client)
    {
        $client->delete();

        return redirect('admin/clients')->with('status', 'Client deleted successfully');
    }
}
