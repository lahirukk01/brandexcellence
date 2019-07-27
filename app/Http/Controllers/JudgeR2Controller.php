<?php

namespace App\Http\Controllers;

use App\Admin;
use App\BlockedEntry;
use App\Brand;
use App\Mail\JudgeEditedScore;
use App\Mail\JudgeFinalized;
use App\Mail\JudgeScored;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class JudgeR2Controller extends Controller
{
    public function index()
    {
        $judge = Auth::user();

        $panels = $judge->panels;
        $categories = [];

        foreach ($panels as $p) {
            $categories = array_merge($categories, $p->categories->pluck('id')->toArray());
        }

        $blockedEntries = BlockedEntry::where('judge_id', $judge->id)->get()->pluck('brand_id')->toArray();

        $brands = Brand::whereIn('category_id', $categories)
            ->whereNotIn('id', $blockedEntries)->where('r2_selected', 1)->get();

        return view('judge.entries_r2', compact('brands', 'judge'));
    }

    public function myScores()
    {
        $judge = Auth::user();

        $brandIds = DB::table('brand_judge')->where('judge_id', $judge->id)
            ->where('round', 2)->pluck('brand_id');

        $brands = Brand::find($brandIds);

        return view('judge.my_scores_r2', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function score(Brand $brand)
    {
        $scoringStart = Carbon::now();
        session(['scoringStart' => $scoringStart]);
        return view('judge.score_r2', compact('brand', 'scoringStart'));
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
        $data['round'] = 2;

        unset($data['_token']);

        Auth::user()->brands()->attach($brand->id, $data);

        $emailData['start'] = session()->pull('scoringStart');
        $emailData['end'] = Carbon::now();
        $emailData['entryId'] = $brand->id_string;
        $emailData['judgeName'] = Auth::user()->name;
        $emailData['round'] = 2;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeScored($emailData));

        return redirect()->route('judge.index2')->with('status', 'Score entered successfully');
    }

    /**
     * Display the score of the brand.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function showScore(Brand $brand)
    {
        $score = Auth::user()->brands()->whereBrandId($brand->id)->get()[1]->score;

        return view('judge.show_r2', compact('score', 'brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $score = Auth::user()->brands()->whereBrandId($brand->id)->get()[1]->score;

        $startEditing = Carbon::now();
        session(['startEditing' => $startEditing]);

        return view('judge.edit_r2', compact('brand', 'score', 'startEditing'));
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

//        Auth::user()->brands()->updateExistingPivot($brand->id, $data);
        DB::table('brand_judge')->where('brand_id', $brand->id)
            ->where('judge_id', Auth::user()->id)
            ->where('round', 2)->update($data);

        $emailData['start'] = session()->pull('startEditing');
        $emailData['end'] = Carbon::now();
        $emailData['entryId'] = $brand->id_string;
        $emailData['judgeName'] = Auth::user()->name;
        $emailData['round'] = 2;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeEditedScore($emailData));

        return redirect()->route('judge.index')->with('status', 'Score edited successfully');
    }

    public function finalize(Request $request)
    {
        $judge = Auth::user();
        $judge->finalized_r2 = true;

        $data['number'] = $request->get('numberOfEntriesFinalized');
        $data['name'] = $judge->name;
        $data['round'] = 2;

        if($judge->save()) {
            $superUserEmail = Admin::whereIsSuper(1)->first()->email;
            Mail::to($superUserEmail)->send(new JudgeFinalized($data));
            return 'success';
        } else {
            return 'failure';
        }
    }

    public function scorePattern()
    {
        $judge = Auth::user();
        $brands = $judge->brands;

        $names = [];
        $scores = [];

        foreach ($brands as $b) {
            $score = $b->score;
            if($score->round == 2) {
                $names[] = $b->name;
                $scores[] = $score->total;
            }
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('judge.score_pattern_r2', compact('names', 'scores'));
    }
}
