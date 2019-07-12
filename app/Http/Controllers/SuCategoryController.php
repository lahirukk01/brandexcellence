<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class SuperUserCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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

        Category::create([
            'name' => $data['name'],
            'code' => $data['code'],
        ]);

        return redirect()->route('categories.index')->with('status', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
            'code' => 'required|max:10|unique:categories',
        ]);

        $data = $request->all();

        $category->update([
            'name' => $data['name'],
            'code' => $data['code'],
        ]);

        return redirect()->route('categories.index')->with('status', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $brands = $category->brands;

        foreach ($brands as $b) {
            $b->delete();
        }

        $category->delete();

        return redirect()->route('categories.index')->with('status', 'Category deleted successfully');
    }
}
