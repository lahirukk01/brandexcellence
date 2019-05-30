<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function categories()
    {
        $categories = Category::all();

        return view('admin.show_categories', compact('categories'));
    }
}
