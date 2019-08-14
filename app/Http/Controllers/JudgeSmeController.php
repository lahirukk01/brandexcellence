<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Mail\JudgeEditedScore;
use App\Mail\JudgeScored;
use App\Sme;
use App\SmeScore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JudgeSmeController extends Controller
{
    public function indexR1()
    {
        $smes = Sme::all();
        $judge = Auth::user();

        $numberOfScoredEntries = SmeScore::whereJudgeId($judge->id)->whereRound(1)->count();

        if(Sme::count() == $numberOfScoredEntries) {
            $judgeHasScoredAll = true;
        } else {
            $judgeHasScoredAll = false;
        }

        $brandsToBeFinalized = [];

        foreach ($smes as $s) {
            if(SmeScore::whereJudgeId($judge->id)->whereSmeId($s->id)->whereRound(1)->count() != 0) {
                $s->judge_has_scored = true;

                if(SmeScore::whereJudgeId($judge->id)->whereSmeId($s->id)->whereRound(1)
                        ->whereJudgeFinalized(true)->count() != 0) {
                    $s->jude_has_finalized = true;
                } else {
                    $s->jude_has_finalized = false;
                    $brandsToBeFinalized[] = $s->id;
                }
            } else {
                $s->judge_has_scored = false;
                $s->jude_has_finalized = false;
            }
        }

        $brandsToBeFinalized = json_encode($brandsToBeFinalized);

        return view('judge.sme.entries_r1', compact('smes', 'judgeHasScoredAll',
            'brandsToBeFinalized'));
    }

    public function scoreR1(Sme $sme)
    {
        $scoringStart = Carbon::now();
        session(['scoringStart' => $scoringStart]);

        return view('judge.sme.score_r1', compact('sme', 'scoringStart'));
    }

    public function storeR1(Request $request, Sme $sme)
    {
        $request->validate([
            'opportunity' => 'required|numeric|min:0|max:10',
            'satisfaction' => 'required|numeric|min:0|max:5',
            'description' => 'required|numeric|min:0|max:5',
            'targeting' => 'required|numeric|min:0|max:5',
            'decision' => 'required|numeric|min:0|max:5',
            'pod' => 'required|numeric|min:0|max:10',
            'identity' => 'required|numeric|min:0|max:5',
            'marketing' => 'required|numeric|min:0|max:40',
            'performance' => 'required|numeric|min:0|max:12',
            'engagement' => 'required|numeric|min:0|max:3',
            'total' => 'required|numeric|min:0|max:100|unique:sme_scores',
            'good' => 'required',
            'bad' => 'required',
            'improvement' => 'required',
        ]);

        $judge = Auth::user();

        $data = $request->except('_token');
        $data['sme_id'] = $sme->id;
        $data['judge_id'] = $judge->id;
        $data['round'] = 1;

        SmeScore::create($data);

        $emailData['start'] = session()->pull('scoringStart');
        $emailData['end'] = Carbon::now();
        $emailData['entryId'] = $sme->id_string;
        $emailData['judgeName'] = $judge->name;
        $emailData['round'] = 1;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeScored($emailData));

        return redirect()->route('judge.sme.index_r1')->with('status', 'Score entered successfully');
    }

    public function editR1(Sme $sme)
    {
        $startEditing = Carbon::now();
        session(['startEditing' => $startEditing]);

        $judge = Auth::user();

        $smeScore = SmeScore::whereSmeId($sme->id)->whereJudgeId($judge->id)->whereRound(1)->first();

        return view('judge.sme.edit_r1', compact('sme', 'smeScore',
            'startEditing', 'judge'));
    }

    public function updateR1(Request $request, Sme $sme)
    {
        $judge = Auth::user();
        $smeScore = SmeScore::whereJudgeId($judge->id)->whereSmeId($sme->id)->whereRound(1)->first();

        $request->validate([
            'opportunity' => 'required|numeric|min:0|max:10',
            'satisfaction' => 'required|numeric|min:0|max:5',
            'description' => 'required|numeric|min:0|max:5',
            'targeting' => 'required|numeric|min:0|max:5',
            'decision' => 'required|numeric|min:0|max:5',
            'pod' => 'required|numeric|min:0|max:10',
            'identity' => 'required|numeric|min:0|max:5',
            'marketing' => 'required|numeric|min:0|max:40',
            'performance' => 'required|numeric|min:0|max:12',
            'engagement' => 'required|numeric|min:0|max:3',
            'total' => 'required|numeric|min:0|max:100|unique:sme_scores,total,' . $smeScore->id,
            'good' => 'required',
            'bad' => 'required',
            'improvement' => 'required',
        ]);

        $data = $request->except('_token');
        $data['sme_id'] = $sme->id;
        $data['judge_id'] = $judge->id;

        $smeScore->update($data);

        $emailData['start'] = session()->pull('startEditing');
        $emailData['end'] = Carbon::now();
        $emailData['entryId'] = $sme->id_string;
        $emailData['judgeName'] = $judge->name;
        $emailData['round'] = 1;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeEditedScore($emailData));

        return redirect()->route('judge.sme.index_r1')->with('status', 'Score updated successfully');
    }

    public function myScoresR1()
    {
        $judge = Auth::user();
        $smeIds = SmeScore::whereJudgeId($judge->id)->whereRound(1)->pluck('sme_id');

        $smes = Sme::find($smeIds);

        return view('judge.sme.my_scores_r1', compact('smes'));
    }

    public function showScoreR1(Sme $sme)
    {
        $judge = Auth::user();
        $smeScore = SmeScore::whereJudgeId($judge->id)->whereSmeId($sme->id)->whereRound(1)->first();

        return view('judge.sme.show_r1', compact('judge', 'sme', 'smeScore'));
    }

    public function scorePatternR1()
    {
        $judge = Auth::user();
        $smeIds = SmeScore::whereJudgeId($judge->id)->whereRound(1)->pluck('sme_id');
        $smes = Sme::find($smeIds);

        $names = [];
        $scores = [];

        foreach ($smes as $b) {
            $names[] = $b->brand_name;
            $scores[] = SmeScore::whereSmeId($b->id)->whereJudgeId($judge->id)->whereRound(1)
                ->pluck('total')[0];
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('judge.sme.score_pattern_r1', compact('names', 'scores'));
    }

    public function indexR2()
    {
        $smes = Sme::whereR2Selected(true)->get();
        $judge = Auth::user();

        $numberOfScoredEntries = SmeScore::whereJudgeId($judge->id)->whereRound(2)->count();

        if($smes->count() == $numberOfScoredEntries) {
            $judgeHasScoredAll = true;
        } else {
            $judgeHasScoredAll = false;
        }

        $brandsToBeFinalized = [];

        foreach ($smes as $s) {
            if(SmeScore::whereJudgeId($judge->id)->whereSmeId($s->id)->whereRound(2)->count() != 0) {
                $s->judge_has_scored = true;

                if(SmeScore::whereJudgeId($judge->id)->whereSmeId($s->id)->whereRound(2)
                        ->whereJudgeFinalized(true)->count() != 0) {
                    $s->jude_has_finalized = true;
                } else {
                    $s->jude_has_finalized = false;
                    $brandsToBeFinalized[] = $s->id;
                }
            } else {
                $s->judge_has_scored = false;
                $s->jude_has_finalized = false;
            }
        }

        $brandsToBeFinalized = json_encode($brandsToBeFinalized);

        return view('judge.sme.entries_r2', compact('smes', 'judgeHasScoredAll',
            'brandsToBeFinalized'));

    }

    public function scoreR2(Sme $sme)
    {
        $scoringStart = Carbon::now();
        session(['scoringStart' => $scoringStart]);

        return view('judge.sme.score_r2', compact('sme', 'scoringStart'));
    }

    public function storeR2(Request $request, Sme $sme)
    {
        $request->validate([
            'opportunity' => 'required|numeric|min:0|max:10',
            'satisfaction' => 'required|numeric|min:0|max:5',
            'description' => 'required|numeric|min:0|max:5',
            'targeting' => 'required|numeric|min:0|max:5',
            'decision' => 'required|numeric|min:0|max:5',
            'pod' => 'required|numeric|min:0|max:10',
            'identity' => 'required|numeric|min:0|max:5',
            'marketing' => 'required|numeric|min:0|max:40',
            'performance' => 'required|numeric|min:0|max:12',
            'engagement' => 'required|numeric|min:0|max:3',
            'total' => 'required|numeric|min:0|max:100|unique:sme_scores',
            'good' => 'required',
            'bad' => 'required',
            'improvement' => 'required',
        ]);

        $judge = Auth::user();

        $data = $request->except('_token');
        $data['sme_id'] = $sme->id;
        $data['judge_id'] = $judge->id;
        $data['round'] = 2;

        SmeScore::create($data);

        $emailData['start'] = session()->pull('scoringStart');
        $emailData['end'] = Carbon::now();
        $emailData['entryId'] = $sme->id_string;
        $emailData['judgeName'] = $judge->name;
        $emailData['round'] = 2;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeScored($emailData));

        return redirect()->route('judge.sme.index_r2')->with('status', 'Score entered successfully');
    }

    public function editR2(Sme $sme)
    {
        $startEditing = Carbon::now();
        session(['startEditing' => $startEditing]);

        $judge = Auth::user();

        $smeScore = SmeScore::whereSmeId($sme->id)->whereJudgeId($judge->id)->whereRound(2)->first();

        return view('judge.sme.edit_r2', compact('sme', 'smeScore',
            'startEditing', 'judge'));
    }

    public function updateR2(Request $request, Sme $sme)
    {
        $judge = Auth::user();
        $smeScore = SmeScore::whereJudgeId($judge->id)->whereSmeId($sme->id)->whereRound(2)->first();

        $request->validate([
            'opportunity' => 'required|numeric|min:0|max:10',
            'satisfaction' => 'required|numeric|min:0|max:5',
            'description' => 'required|numeric|min:0|max:5',
            'targeting' => 'required|numeric|min:0|max:5',
            'decision' => 'required|numeric|min:0|max:5',
            'pod' => 'required|numeric|min:0|max:10',
            'identity' => 'required|numeric|min:0|max:5',
            'marketing' => 'required|numeric|min:0|max:40',
            'performance' => 'required|numeric|min:0|max:12',
            'engagement' => 'required|numeric|min:0|max:3',
            'total' => 'required|numeric|min:0|max:100|unique:sme_scores,total,' . $smeScore->id,
            'good' => 'required',
            'bad' => 'required',
            'improvement' => 'required',
        ]);

        $data = $request->except('_token');
        $data['sme_id'] = $sme->id;
        $data['judge_id'] = $judge->id;

        $smeScore->update($data);

        $emailData['start'] = session()->pull('startEditing');
        $emailData['end'] = Carbon::now();
        $emailData['entryId'] = $sme->id_string;
        $emailData['judgeName'] = $judge->name;
        $emailData['round'] = 2;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeEditedScore($emailData));

        return redirect()->route('judge.sme.index_r2')->with('status', 'Score updated successfully');
    }

    public function myScoresR2()
    {
        $judge = Auth::user();
        $smeIds = SmeScore::whereJudgeId($judge->id)->whereRound(2)->pluck('sme_id');

        $smes = Sme::find($smeIds);

        return view('judge.sme.my_scores_r2', compact('smes'));
    }

    public function showScoreR2(Sme $sme)
    {
        $judge = Auth::user();
        $smeScore = SmeScore::whereJudgeId($judge->id)->whereSmeId($sme->id)->whereRound(2)->first();

        return view('judge.sme.show_r2', compact('judge', 'sme', 'smeScore'));
    }

    public function scorePatternR2()
    {
        $judge = Auth::user();
        $smeIds = SmeScore::whereJudgeId($judge->id)->whereRound(2)->pluck('sme_id');
        $smes = Sme::find($smeIds);

        $names = [];
        $scores = [];

        foreach ($smes as $b) {
            $names[] = $b->brand_name;
            $scores[] = round(SmeScore::whereSmeId($b->id)->whereJudgeId($judge->id)->whereRound(2)
                ->pluck('total')[0], 1);
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('judge.sme.score_pattern_r2', compact('names', 'scores'));
    }
}
