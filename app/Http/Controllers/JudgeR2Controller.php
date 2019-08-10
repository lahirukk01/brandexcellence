<?php

namespace App\Http\Controllers;

use App\Admin;
use App\BlockedEntry;
use App\Brand;
use App\BrandJudge;
use App\CsrScore;
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

        $numberOfScoredEntries = 0;
        $brandsToBeFinalized = [];

        foreach ($brands as $b) {

            if($b->category->code == 'CSR') {
                if(CsrScore::whereBrandId($b->id)->whereJudgeId($judge->id)->whereRound(2)
                        ->whereJudgeFinalized(true)->count() != 0) {
                    $b->judge_has_finalized = true;
                }else {
                    $b->judge_has_finalized = false;
                    $brandsToBeFinalized[] = $b->id;
                }

                if(CsrScore::whereBrandId($b->id)->whereJudgeId($judge->id)->whereRound(2)
                        ->count() != 0) {
                    $b->judge_has_scored = true;
                    $numberOfScoredEntries++;
                } else {
                    $b->judge_has_scored = false;
                }
            } else {

                if(BrandJudge::whereBrandId($b->id)->whereJudgeId($judge->id)->whereRound(2)->whereJudgeFinalized(true)->count() != 0) {
                    $b->judge_has_finalized = true;
                } else {
                    $b->judge_has_finalized = false;
                    $brandsToBeFinalized[] = $b->id;
                }

                if($b->judges()->whereJudgeId($judge->id)->where('round', 2)->count() != 0) {
                    $b->judge_has_scored = true;
                    $numberOfScoredEntries++;
                } else {
                    $b->judge_has_scored = false;
                }
            }
        }

        if($numberOfScoredEntries === $brands->count()) {
            $judgeHasScoredAll = true;
        } else {
            $judgeHasScoredAll = false;
        }

        if(count($brandsToBeFinalized) == 0) {
            $brandsToBeFinalized = '[]';
        } else {
            $brandsToBeFinalized = json_encode($brandsToBeFinalized);
        }

        return view('judge.entries_r2', compact('brands', 'judgeHasScoredAll',
            'brandsToBeFinalized'));
    }

    public function myScores()
    {
        $judge = Auth::user();

        $brandIds = DB::table('brand_judge')->where('judge_id', $judge->id)
            ->where('round', 2)->pluck('brand_id');

        $brands = Brand::find($brandIds);

        $csrBrandIds = CsrScore::whereJudgeId($judge->id)->whereRound(2)->pluck('brand_id');

        $brands = $brands->concat(Brand::find($csrBrandIds));

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

        if($brand->category->code == 'CSR') {
            $view = 'judge.score_r2';
        } else {
            $view = 'judge.score_r2';
        }

        return view($view, compact('brand', 'scoringStart'));
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
            'total' => 'required|min:0|max:100|unique:brand_judge',
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

    public function storeCsr(Request $request, Brand $brand)
    {
        $request->validate([
            'intent' => 'required|min:0|max:10',
            'recipient' => 'required|min:0|max:5',
            'purpose' => 'required|min:0|max:10',
            'vision' => 'required|min:0|max:5',
            'mission' => 'required|min:0|max:5',
            'identity' => 'required|min:0|max:10',
            'strategic' => 'required|min:0|max:25',
            'activities' => 'required|min:0|max:15',
            'communication' => 'required|min:0|max:7',
            'internal' => 'required|min:0|max:8',
            'total' => 'required|min:0|max:100|unique:csr_scores',
            'good' => 'required',
            'bad' => 'required',
            'improvement' => 'required',
        ]);

        $data = $request->all();
        $data['round'] = 2;

        unset($data['_token']);

        $data['brand_id'] = $brand->id;
        $data['judge_id'] = Auth::user()->id;

        CsrScore::create($data);

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
        if($brand->category->code == 'CSR') {
            $csrScore = CsrScore::whereBrandId($brand->id)->whereJudgeId(Auth::user()->id)
                ->whereRound(2)->first();
            return view('judge.show_r2', compact('csrScore', 'brand'));
        } else {
            $score = Auth::user()->brands()->whereBrandId($brand->id)->whereRound(2)->first()->score;
            return view('judge.show_r2', compact('score', 'brand'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $startEditing = Carbon::now();
        session(['startEditing' => $startEditing]);

        if($brand->category->code == 'CSR') {
            $csrScore = CsrScore::whereJudgeId(Auth::user()->id)->whereBrandId($brand->id)
                ->whereRound(2)->first();

            return view('judge.edit_r2', compact('brand', 'csrScore', 'startEditing'));
        } else {
            $score = Auth::user()->brands()->whereBrandId($brand->id)->whereRound(2)->first()->score;
            return view('judge.edit', compact('brand', 'score', 'startEditing'));
        }
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

        return redirect()->route('judge.index2')->with('status', 'Score edited successfully');
    }

    public function updateCsr(Request $request, Brand $brand)
    {
        $csrScore = CsrScore::whereBrandId($brand->id)->whereJudgeId(Auth::user()->id)
            ->whereRound(2)->first();

        $request->validate([
            'intent' => 'required|min:0|max:10',
            'recipient' => 'required|min:0|max:5',
            'purpose' => 'required|min:0|max:10',
            'vision' => 'required|min:0|max:5',
            'mission' => 'required|min:0|max:5',
            'identity' => 'required|min:0|max:10',
            'strategic' => 'required|min:0|max:25',
            'activities' => 'required|min:0|max:15',
            'communication' => 'required|min:0|max:7',
            'internal' => 'required|min:0|max:8',
            'total' => 'required|min:0|max:100|unique:csr_scores,total,' . $csrScore->id,
            'good' => 'required',
            'bad' => 'required',
            'improvement' => 'required',
        ]);

        $data = $request->all();

        unset($data['_token'], $data['_method']);

        $csrScore->update($data);

        $emailData['start'] = session()->pull('startEditing');
        $emailData['end'] = Carbon::now();
        $emailData['entryId'] = $brand->id_string;
        $emailData['judgeName'] = Auth::user()->name;
        $emailData['round'] = 2;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeEditedScore($emailData));

        return redirect()->route('judge.index2')->with('status', 'Score edited successfully');
    }

    public function finalize(Request $request)
    {
        $judge = Auth::user();

        $brandsToBeFinalized = $request->brandsToBeFinalized;

        BrandJudge::whereJudgeId($judge->id)->whereIn('brand_id', $brandsToBeFinalized)->where('round', 2)
            ->update(['judge_finalized' => true]);
        CsrScore::whereJudgeId($judge->id)->whereIn('brand_id', $brandsToBeFinalized)->where('round', 2)
            ->update(['judge_finalized' => true]);

        $data['number'] = count($brandsToBeFinalized);
        $data['name'] = $judge->name;
        $data['round'] = 2;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeFinalized($data));
        return response()->json('success');
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

        $csrBrands = CsrScore::whereJudgeId($judge->id)->whereRound(2)->get();

        foreach ($csrBrands as $b) {
            $names[] = $b->brand->name;
            $scores[] = $b->total;
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('judge.score_pattern_r2', compact('names', 'scores'));
    }
}
