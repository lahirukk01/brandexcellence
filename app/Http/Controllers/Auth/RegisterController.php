<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Mail\ClientRegistered;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'designation' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'digits:10'],

            'company_name' => ['required', 'string', 'max:255'],
            'company_address' => ['required', 'string', 'max:255'],
            'ceo_name' => ['required', 'string', 'max:100'],
            'ceo_email' => ['required', 'string', 'email', 'max:100'],
            'ceo_contact_number' => ['required', 'string', 'digits:10'],
            'vat_registration_number' => ['nullable', 'regex:/[0-9\-]{5,15}/g'],

            'password' => ['required', 'string', 'min:3', 'max:15', 'alpha_num', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'designation' => $data['designation'],
            'contact_number' => $data['contact_number'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $data = $request->all();

        Company::create([
            'name' => $data['company_name'],
            'address' => $data['company_address'],
            'ceo_name' => $data['ceo_name'],
            'ceo_email' => $data['ceo_email'],
            'ceo_contact_number' => $data['ceo_contact_number'],
            'vat_registration_number' => $data['vat_registration_number'],
            'svat' => isset($data['svat-checkbox']) ? 1 : 0,
            'nbt' => isset($data['nbt-checkbox']) ? 1 : 0,
            'user_id' => $user->id,
        ]);

        unset($data['password']);
        unset($data['password_confirmation']);

        $superUserEmail = User::where('role_id', 1)->first()->email;
        Mail::to($user->email)->cc($superUserEmail)->send(new ClientRegistered($data));
    }
}
