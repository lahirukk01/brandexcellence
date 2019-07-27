<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Judge;
//use App\User;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

class AdminScoreController extends Controller
{
    public function judgeWise()
    {
        $judges = Judge::all();
        return view('admin.scores.judge_wise', compact('judges'));
    }

    public function entryWise()
    {
        $brands = Brand::has('judges')->get();
        return view('admin.scores.entry_wise', compact('brands'));
    }

    public function judgeWiseEntries(Judge $judge)
    {
        $brands = $judge->brands;

        $names = [];
        $scores = [];

        foreach ($brands as $b) {
            $names[] = $b->name;
            $scores[] = $b->score->total;
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('admin.scores.judge_wise_entries', compact('brands', 'judge', 'names', 'scores'));

    }

    public function entryWiseJudges(Brand $brand)
    {
        $judges = $brand->judges;

        $names = [];
        $scores = [];

        foreach ($judges as $j) {
            $names[] = $j->name;
            $scores[] = $j->score->total;
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('admin.scores.entry_wise_judges', compact('judges', 'brand', 'names', 'scores'));
    }

    public function show(Judge $judge, Brand $brand, $direction)
    {
        $score = $judge->brands()->whereBrandId($brand->id)->first()->score;

        return view('admin.scores.show', compact('score', 'direction', 'judge', 'brand'));
    }
}
