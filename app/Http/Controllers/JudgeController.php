<?php

namespace App\Http\Controllers;

use App\BlockedEntry;
use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JudgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $judge = Auth::user();
        $industryCategories = $judge->industryCategories->pluck('id')->toArray();

        $blockedEntries = BlockedEntry::where('user_id', $judge->id)->get()->pluck('brand_id')->toArray();

        $brands = Brand::whereIn('industry_category_id', $industryCategories)
            ->whereNotIn('id', $blockedEntries)->get();

        return view('judge.dashboard', compact('brands'));
    }

    public function myScores()
    {
        $judge = Auth::user();
        $brands = $judge->brands;

        return view('judge.my_scores', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function score(Brand $brand)
    {
        return view('judge.score', compact('brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Brand $brand)
    {
        $request->validate([
            'intent' => 'required|min:0|max:15',
            'content' => 'required|min:0|max:15',
            'process' => 'required|min:0|max:40',
            'health' => 'required|min:0|max:18',
            'performance' => 'required|min:0|max:12',
            'good' => 'required',
            'bad' => 'required',
            'improvement' => 'required',
        ]);

        $data = $request->all();

        unset($data['_token']);

        Auth::user()->brands()->attach($brand->id, $data);

        return redirect()->route('judge.index')->with('status', 'Score entered successfully');
    }

    /**
     * Display the score of the brand.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function showScore(Brand $brand)
    {
        $score = Auth::user()->brands()->whereBrandId($brand->id)->first()->score;

        return view('judge.show', compact('score', 'brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $score = Auth::user()->brands()->whereBrandId($brand->id)->first()->score;

        return view('judge.edit', compact('brand', 'score'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'intent' => 'required|min:0|max:15',
            'content' => 'required|min:0|max:15',
            'process' => 'required|min:0|max:40',
            'health' => 'required|min:0|max:18',
            'performance' => 'required|min:0|max:12',
            'good' => 'required',
            'bad' => 'required',
            'improvement' => 'required',
        ]);

        $data = $request->all();

        unset($data['_token'], $data['_method']);

        Auth::user()->brands()->updateExistingPivot($brand->id, $data);

        return redirect()->route('judge.index')->with('status', 'Score edited successfully');
    }
}
