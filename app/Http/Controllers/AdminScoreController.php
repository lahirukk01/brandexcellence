<?php

namespace App\Http\Controllers;

use App\Brand;
use App\BrandJudge;
use App\CsrScore;
use App\Judge;
use Illuminate\Support\Facades\DB;


class AdminScoreController extends Controller
{
    public function judgeWise()
    {
        $judgeIds = BrandJudge::whereRound(1)->pluck('judge_id');
        $csrJudgeIds = CsrScore::whereRound(1)->pluck('judge_id');

        $allJudgeIds = $judgeIds->concat($csrJudgeIds);
        $judges = Judge::find($allJudgeIds);

        foreach ($judges as $j) {
            $brandsTotals = BrandJudge::whereJudgeId($j->id)->whereRound(1)->pluck('total');
            $csrBrandsTotals = CsrScore::whereJudgeId($j->id)->whereRound(1)->pluck('total');

            $allTotals = $brandsTotals->concat($csrBrandsTotals);
            $j->average = round( $allTotals->average(), 2);
        }

        return view('admin.scores.judge_wise', compact('judges'));
    }

    public function entryWise()
    {
        $brandIds = BrandJudge::whereRound(1)->pluck('brand_id');
        $brands = Brand::find($brandIds);

        foreach ($brands as $b) {
            $b->average = round( BrandJudge::whereBrandId($b->id)
                ->whereRound(1)->pluck('total')->average(),2);
        }

        $csrBrandIds = CsrScore::whereRound(1)->pluck('brand_id');
        $csrBrands = Brand::find($csrBrandIds);

        foreach ($csrBrands as $b) {
            $b->average = round( CsrScore::whereBrandId($b->id)
                ->whereRound(1)->pluck('total')->average(),2);
        }

        $brands = $brands->concat($csrBrands);

        return view('admin.scores.entry_wise', compact('brands'));
    }

    public function judgeWiseEntries(Judge $judge)
    {
        $brandIds = BrandJudge::whereRound(1)
            ->whereJudgeId($judge->id)->pluck('brand_id');

        $brands = Brand::find($brandIds);

        $names = [];
        $scores = [];

        foreach ($brands as $b) {
            $names[] = $b->name;
            $scores[] = BrandJudge::whereBrandId($b->id)->whereJudgeId($judge->id)->whereRound(1)
                ->pluck('total')[0];
        }

        $csrBrandIds = CsrScore::whereRound(1)->whereJudgeId($judge->id)->pluck('brand_id');
        $csrBrands = Brand::find($csrBrandIds);

        foreach ($csrBrands as $b) {
            $names[] = $b->name;
            $scores[] = CsrScore::whereBrandId($b->id)->whereJudgeId($judge->id)->whereRound(1)
                ->pluck('total')[0];
        }

        $brands = $brands->concat($csrBrands);

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('admin.scores.judge_wise_entries', compact('brands', 'judge', 'names', 'scores'));
    }

    public function entryWiseJudges(Brand $brand)
    {
        $names = [];
        $scores = [];

        if($brand->category->code == 'CSR') {
            $judgeIds = CsrScore::whereRound(1)
                ->whereBrandId($brand->id)->pluck('judge_id');
            $judges = Judge::find($judgeIds);

            foreach ($judges as $j) {
                $names[] = $j->name;
                $scores[] = CsrScore::whereBrandId($brand->id)->whereJudgeId($j->id)->whereRound(1)
                    ->pluck('total')[0];
            }

        } else {
            $judgeIds = BrandJudge::whereRound(1)
                ->whereBrandId($brand->id)->pluck('judge_id');
            $judges = Judge::find($judgeIds);

            foreach ($judges as $j) {
                $names[] = $j->name;
                $scores[] = BrandJudge::whereBrandId($brand->id)->whereJudgeId($j->id)->whereRound(1)
                    ->pluck('total')[0];
            }
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('admin.scores.entry_wise_judges', compact('judges', 'brand', 'names', 'scores'));
    }

    public function show(Judge $judge, Brand $brand, $direction)
    {
        if($brand->category->code == 'CSR') {
            $score = CsrScore::whereJudgeId($judge->id)->whereBrandId($brand->id)->whereRound(1)->first();
            return view('admin.scores.show_csr', compact('score', 'direction', 'judge', 'brand'));
        } else {
            $score = BrandJudge::whereJudgeId($judge->id)->whereBrandId($brand->id)->whereRound(1)->first();
            return view('admin.scores.show', compact('score', 'direction', 'judge', 'brand'));
        }
    }
}
