<?php

namespace App\Http\Controllers;

use App\Brand;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminScoreController extends Controller
{
    public function judgeWise()
    {
        $judges = User::whereRoleId(3)->get();
        return view('admin.scores.judge_wise', compact('judges'));
    }

    public function entryWise()
    {
        $brands = Brand::has('users')->get();
        return view('admin.scores.entry_wise', compact('brands'));
    }

    public function judgeWiseEntries(User $judge)
    {
        $brands = $judge->brands;
        return view('admin.scores.judge_wise_entries', compact('brands', 'judge'));

    }

    public function entryWiseJudges(Brand $brand)
    {
        $judges = $brand->users;

        return view('admin.scores.entry_wise_judges', compact('judges', 'brand'));
    }

    public function show(User $judge, Brand $brand, $direction)
    {
        $score = $judge->brands()->whereBrandId($brand->id)->first()->score;

        return view('admin.scores.show', compact('score', 'direction', 'judge', 'brand'));
    }
}
