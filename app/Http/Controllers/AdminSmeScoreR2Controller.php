<?php

namespace App\Http\Controllers;

use App\Judge;
use App\Sme;
use App\SmeScore;

class AdminSmeScoreR2Controller extends Controller
{
    public function judgeWise()
    {
        $judgeIds = SmeScore::whereRound(2)->pluck('judge_id');
        $judges = Judge::find($judgeIds);

        foreach ($judges as $j) {
            $j->average = round(SmeScore::whereRound(2)->whereJudgeId($j->id)->pluck('total')
                ->average(), 1);
        }

        return view('admin.sme_scores.judge_wise_r2', compact('judges'));
    }

    public function entryWise()
    {
        $smeIds = SmeScore::whereRound(2)->pluck('sme_id');
        $smes = Sme::find($smeIds);

        foreach ($smes as $s) {
            $s->average = round(SmeScore::whereRound(2)->whereSmeId($s->id)->pluck('total')
                ->average(), 1);
        }

        return view('admin.sme_scores.entry_wise_r2', compact('smes'));
    }

    public function judgeWiseEntries(Judge $judge)
    {
        $smeIds = SmeScore::whereJudgeId($judge->id)->whereRound(2)->pluck('sme_id');
        $smes = Sme::find($smeIds);

        $names = [];
        $scores = [];

        foreach ($smes as $s) {
            $names[] = $s->brand_name;
            $scores[] = round(SmeScore::whereSmeId($s->id)->whereJudgeId($judge->id)->whereRound(2)
                ->first()->total, 1);
            $s->scoreDetails = SmeScore::whereSmeId($s->id)->whereJudgeId($judge->id)->whereRound(2)->first();
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('admin.sme_scores.judge_wise_entries_r2', compact('judge',
            'smes', 'names', 'scores'));
    }

    public function show(Judge $judge, Sme $sme, $direction)
    {
        $smeScore = SmeScore::whereJudgeId($judge->id)->whereSmeId($sme->id)->whereRound(2)->first();
        return view('admin.sme_scores.show_r2', compact('smeScore', 'direction', 'judge', 'sme'));
    }

    public function entryWiseJudges(Sme $sme)
    {
        $judgeIds = SmeScore::whereSmeId($sme->id)->whereRound(2)->pluck('judge_id');
        $judges = Judge::find($judgeIds);

        $names = [];
        $scores = [];

        foreach ($judges as $j) {
            $names[] = $j->name;
            $scores[] = round(SmeScore::whereJudgeId($j->id)->whereSmeId($sme->id)->whereRound(2)
                ->first()->total, 1);
            $j->scoreDetails = SmeScore::whereSmeId($sme->id)->whereJudgeId($j->id)->whereRound(2)->first();
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('admin.sme_scores.entry_wise_judges_r2', compact('judges', 'sme',
            'names', 'scores'));
    }
}
