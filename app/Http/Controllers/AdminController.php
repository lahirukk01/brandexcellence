<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\IndustryCategory;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data['clients'] = User::whereRoleId(4)->count();
        $data['brands'] = Brand::count();
        $data['judges'] = User::whereRoleId(3)->count();
        return view('admin.dashboard', compact('data'));
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
}
