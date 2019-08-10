<?php

namespace App\Http\Controllers;

use App\Brand;
use App\BrandJudge;
use App\Category;
use App\CsrScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWinnerController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.winners.categories', compact('categories'));
    }

    public function showCategoryResults(Category $category)
    {
        $brands = Brand::whereCategoryId($category->id)->where('auditor_id', '!=', null)
            ->get(['name', 'id', 'medal']);

        $categoryCode = Category::findOrFail($category->id)->code;

        foreach ($brands as $b) {
            if($categoryCode == 'CSR') {
                $scores = CsrScore::whereBrandId($b->id)->whereRound(2)->pluck('total');
            } else {
                $scores = BrandJudge::whereBrandId($b->id)->whereRound(2)->pluck('total');
            }

            if($scores->count() > 3) {
                $sum = $scores->sum() - $scores->min() - $scores->max();
                $b->average = $sum / ($scores->count() - 2);
            } else {
                $b->average = $scores->avg();
            }
        }

        $brands = $brands->sortByDesc('average');
        return view('admin.winners.winner_select', compact('brands'));
    }

    public function setWinners(Request $request)
    {
        $results = $request->results;

        foreach ($results as $r) {
            Brand::whereId($r[0])->update(['medal' => $r[1]]);
        }

        return response()->json('success');
    }
}
