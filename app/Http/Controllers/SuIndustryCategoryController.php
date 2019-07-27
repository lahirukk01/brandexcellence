<?php

namespace App\Http\Controllers;

use App\IndustryCategory;
use Illuminate\Http\Request;

class SuIndustryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $industryCategories = IndustryCategory::all();
        return view('admin.industry_categories.index', compact('industryCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.industry_categories.create');
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
            'name' => 'required|max:255|unique:categories',
            'code' => 'required|max:10|unique:categories',
        ]);

        $data = $request->all();

        IndustryCategory::create([
            'name' => $data['name'],
            'code' => $data['code'],
        ]);

        return redirect()->route('super.industry_category.index')->with('status', 'Industry Category created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IndustryCategory  $industry_category
     * @return \Illuminate\Http\Response
     */
    public function edit(IndustryCategory $industry_category)
    {
        $industryCategory = $industry_category;
        return view('admin.industry_categories.edit', compact('industryCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IndustryCategory  $industry_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IndustryCategory $industry_category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
            'code' => 'required|max:10|unique:categories',
        ]);

        $data = $request->all();

        $industry_category->update([
            'name' => $data['name'],
            'code' => $data['code'],
        ]);

        return redirect()->route('super.industry_category.index')->with('status', 'Industry Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IndustryCategory  $industry_category
     * @return \Illuminate\Http\Response
     */
//    public function destroy(IndustryCategory $industry_category)
//    {
//        $industry_category->delete();
//
//        return redirect()->route('industry_categories.index')->with('status', 'Industry Category deleted successfully');
//    }
}
