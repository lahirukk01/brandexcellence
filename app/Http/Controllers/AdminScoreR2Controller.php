<?php

namespace App\Http\Controllers;

use App\Brand;
use App\BrandJudge;
use App\CsrScore;
use App\Judge;
use Illuminate\Support\Facades\DB;


class AdminScoreR2Controller extends Controller
{
    public function judgeWise()
    {
        $judgeIds = BrandJudge::whereRound(2)->pluck('judge_id');
        $csrJudgeIds = CsrScore::whereRound(2)->pluck('judge_id');

        $allJudgeIds = $judgeIds->concat($csrJudgeIds);
        $judges = Judge::find($allJudgeIds);

        foreach ($judges as $j) {
            $brandsTotals = BrandJudge::whereJudgeId($j->id)->whereRound(2)->pluck('total');
            $csrBrandsTotals = CsrScore::whereJudgeId($j->id)->whereRound(2)->pluck('total');

            $allTotals = $brandsTotals->concat($csrBrandsTotals);
            $j->average = round( $allTotals->average(), 1);
        }

        return view('admin.scores.judge_wise_r2', compact('judges'));
    }

    public function entryWise()
    {
        $brandIds = BrandJudge::whereRound(2)->pluck('brand_id');
        $brands = Brand::find($brandIds);

        foreach ($brands as $b) {
            $b->average = round( BrandJudge::whereBrandId($b->id)
                ->whereRound(2)->pluck('total')->average(),1);
        }

        $csrBrandIds = CsrScore::whereRound(2)->pluck('brand_id');
        $csrBrands = Brand::find($csrBrandIds);

        foreach ($csrBrands as $b) {
            $b->average = round( CsrScore::whereBrandId($b->id)
                ->whereRound(2)->pluck('total')->average(),1);
        }

        $brands = $brands->concat($csrBrands);

        return view('admin.scores.entry_wise_r2', compact('brands'));
    }

    public function judgeWiseEntries(Judge $judge)
    {
        $brandIds = BrandJudge::whereRound(2)
            ->whereJudgeId($judge->id)->pluck('brand_id');

        $brands = Brand::find($brandIds);

        $names = [];
        $scores = [];

        foreach ($brands as $b) {
            $names[] = $b->name;
            $scores[] = round(BrandJudge::whereBrandId($b->id)->whereJudgeId($judge->id)->whereRound(2)
                ->first()->total, 1);
            $b->scoreDetails = BrandJudge::whereBrandId($b->id)->whereJudgeId($judge->id)->whereRound(2)
                ->first();
        }

        $csrBrandIds = CsrScore::whereRound(2)->whereJudgeId($judge->id)->pluck('brand_id');
        $csrBrands = Brand::find($csrBrandIds);

        foreach ($csrBrands as $b) {
            $names[] = $b->name;
            $scores[] = round(CsrScore::whereBrandId($b->id)->whereJudgeId($judge->id)->whereRound(2)
                ->first()->total, 1);
            $b->scoreDetails = null;
        }

        $brands = $brands->concat($csrBrands);

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('admin.scores.judge_wise_entries_r2', compact('brands', 'judge', 'names', 'scores'));
    }

    public function entryWiseJudges(Brand $brand)
    {
        $names = [];
        $scores = [];

        if($brand->category->code == 'CSR') {
            $judgeIds = CsrScore::whereRound(2)
                ->whereBrandId($brand->id)->pluck('judge_id');
            $judges = Judge::find($judgeIds);

            foreach ($judges as $j) {
                $names[] = $j->name;
                $scores[] = round(CsrScore::whereBrandId($brand->id)->whereJudgeId($j->id)->whereRound(2)
                    ->first()->total, 1);
                $j->scoreDetails = null;
            }

        } else {
            $judgeIds = BrandJudge::whereRound(2)
                ->whereBrandId($brand->id)->pluck('judge_id');
            $judges = Judge::find($judgeIds);

            foreach ($judges as $j) {
                $names[] = $j->name;
                $scores[] = round(BrandJudge::whereBrandId($brand->id)->whereJudgeId($j->id)->whereRound(2)
                    ->first()->total, 1);
                $j->scoreDetails = BrandJudge::whereBrandId($brand->id)->whereJudgeId($j->id)->whereRound(2)
                    ->first();
            }
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('admin.scores.entry_wise_judges_r2', compact('judges', 'brand', 'names', 'scores'));
    }

    public function show(Judge $judge, Brand $brand, $direction)
    {
        if($brand->category->code == 'CSR') {
            $score = CsrScore::whereJudgeId($judge->id)->whereBrandId($brand->id)->whereRound(2)->first();
            return view('admin.scores.show_csr_r2', compact('score', 'direction', 'judge', 'brand'));
        } else {
            $score = BrandJudge::whereJudgeId($judge->id)->whereBrandId($brand->id)->whereRound(2)->first();
            return view('admin.scores.show2', compact('score', 'direction', 'judge', 'brand'));
        }
    }
}
