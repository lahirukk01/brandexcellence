<?php

namespace App\Http\Controllers;

use App\Brand;
use App\BrandJudge;
use App\Category;
use App\CsrScore;
use App\Sme;
use App\SmeScore;
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
        if($category->code == 'SME') {
            $brands = Sme::where('auditor_id', '!=', null)->get(['name', 'id', 'medal']);

            foreach ($brands as $b) {
                $scores = SmeScore::whereSmeId($b->id)->whereRound(2)->pluck('total');

                if($scores->count() > 3) {
                    $sum = $scores->sum() - $scores->min() - $scores->max();
                    $b->average = round($sum / ($scores->count() - 2), 1);
                } else {
                    $b->average = round($scores->avg(), 1);
                }
            }
        } else {
            $brands = Brand::whereCategoryId($category->id)->where('auditor_id', '!=', null)
                ->get(['name', 'id', 'medal']);

            $categoryCode = $category->code;

            foreach ($brands as $b) {
                if($categoryCode == 'CSR') {
                    $scores = CsrScore::whereBrandId($b->id)->whereRound(2)->pluck('total');
                } else {
                    $scores = BrandJudge::whereBrandId($b->id)->whereRound(2)->pluck('total');
                }

                if($scores->count() > 3) {
                    $sum = $scores->sum() - $scores->min() - $scores->max();
                    $b->average = round($sum / ($scores->count() - 2), 1);
                } else {
                    $b->average = round($scores->avg(), 1);
                }
            }
        }

        $categoryCode = $category->code;
        $brands = $brands->sortByDesc('average');
        return view('admin.winners.winner_select', compact('brands', 'categoryCode'));
    }

    public function setWinners(Request $request)
    {
        $results = $request->results;
        $categoryCode = $request->categoryCode;

        if($categoryCode == 'SME') {
            foreach ($results as $r) {
                Sme::whereId($r[0])->update(['medal' => $r[1]]);
            }
        } else {
            foreach ($results as $r) {
                Brand::whereId($r[0])->update(['medal' => $r[1]]);
            }
        }

        return response()->json('success');
    }
}
