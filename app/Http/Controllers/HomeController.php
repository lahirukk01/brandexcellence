<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch(Auth::user()->role_id)
        {
            case 1:
                return view('admin.dashboard');
                break;
            case 2:
                break;
            case 3:
                break;
            case 4:

                $client = Auth::user();
                return view('client.dashboard', compact('client'));

                break;
            default:
                die('Invalid user role');
                break;
        }
    }
}
