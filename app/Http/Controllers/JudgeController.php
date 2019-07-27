<?php

namespace App\Http\Controllers;

use App\Admin;
use App\BlockedEntry;
use App\Brand;
//use App\Judge;
use App\Mail\JudgeEditedScore;
use App\Mail\JudgeFinalized;
use App\Mail\JudgeScored;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class JudgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $judge = Auth::user();
        $industryCategories = $judge->industryCategories->pluck('id')->toArray();

        $blockedEntries = BlockedEntry::where('judge_id', $judge->id)->get()->pluck('brand_id')->toArray();

        $brands = Brand::whereIn('industry_category_id', $industryCategories)
            ->whereNotIn('id', $blockedEntries)->get();

        return view('judge.entries', compact('brands'));
    }

    public function myScores()
    {
        $judge = Auth::user();
        $brands = $judge->brands()->where('r2_selected', 0)->get();

        return view('judge.my_scores', compact('brands'));
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
        return view('judge.score', compact('brand', 'scoringStart'));
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
        $data['round'] = 1;

        unset($data['_token']);

        Auth::user()->brands()->attach($brand->id, $data);

        $emailData['start'] = session()->pull('scoringStart');
        $emailData['end'] = Carbon::now();
        $emailData['entryId'] = $brand->id_string;
        $emailData['judgeName'] = Auth::user()->name;
        $emailData['round'] = 1;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeScored($emailData));

        return redirect()->route('judge.index')->with('status', 'Score entered successfully');
    }

    /**
     * Display the score of the brand.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function showScore(Brand $brand)
    {
        $score = Auth::user()->brands()->whereBrandId($brand->id)->first()->score;

        return view('judge.show', compact('score', 'brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $score = Auth::user()->brands()->whereBrandId($brand->id)->first()->score;

        $startEditing = Carbon::now();
        session(['startEditing' => $startEditing]);

        return view('judge.edit', compact('brand', 'score', 'startEditing'));
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

        Auth::user()->brands()->updateExistingPivot($brand->id, $data);

        $emailData['start'] = session()->pull('startEditing');
        $emailData['end'] = Carbon::now();
        $emailData['entryId'] = $brand->id_string;
        $emailData['judgeName'] = Auth::user()->name;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($superUserEmail)->send(new JudgeEditedScore($emailData));

        return redirect()->route('judge.index')->with('status', 'Score edited successfully');
    }

    public function finalize(Request $request)
    {
        $judge = Auth::user();
        $judge->finalized = true;

        $data['number'] = $request->get('numberOfEntriesFinalized');
        $data['name'] = $judge->name;
        $data['round'] = 1;

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
            $names[] = $b->name;
            $scores[] = $b->score->total;
        }

        $names = json_encode($names);
        $scores = json_encode($scores);

        return view('judge.score_pattern', compact('names', 'scores'));
    }

    ///////////////////////////// Inside Password Reset ///////////////////////////////////

    public function selfUpdatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string', 'min:3', 'max:15', 'alpha_num',],
            'password' => ['required', 'string', 'min:3', 'max:15', 'alpha_num', 'confirmed'],
        ]);

        $currentPassword = $request->input('current_password');

        if( ! Hash::check( $currentPassword, $user->password)) {
            return redirect()->back()->with('passwordError', 'Invalid current password');
        }

        $password = $request->input('password');

        $user->update([
            'password' => Hash::make($password)
        ]);

        return redirect('judge')->with('status', 'Password updated successfully');
    }

    public function showInsidePasswordResetForm()
    {
        return view('judge.reset_password');
    }
}
