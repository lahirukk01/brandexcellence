<?php

namespace App\Http\Controllers;

use App\BlockedEntry;
use App\Brand;
use App\BrandJudge;
use App\CsrScore;
use App\Flag;
use App\IndustryCategory;
use App\Judge;
use App\Mail\JudgeRegistered;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminJudgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $judges = Judge::all();

        $currentRound = Flag::first()->current_round;

        foreach ($judges as $j) {
            $numberOfScoredNormalEntries = BrandJudge::whereJudgeId($j->id)->whereRound($currentRound)->count();
            $numberOfScoredCsrEntries = CsrScore::whereJudgeId($j->id)->whereRound($currentRound)->count();

            $numberOfFinalizedNormalEntries = BrandJudge::whereJudgeId($j->id)->whereRound($currentRound)
                ->whereJudgeFinalized(true)->count();
            $numberOfFinalizedCsrEntries = CsrScore::whereJudgeId($j->id)->whereRound($currentRound)
                ->whereJudgeFinalized(true)->count();

            $numberOfTotalScoredEntries = $numberOfScoredNormalEntries + $numberOfScoredCsrEntries;
            $numberOfTotalFinalizedEntries = $numberOfFinalizedNormalEntries + $numberOfFinalizedCsrEntries;

            if($numberOfTotalScoredEntries == $numberOfTotalFinalizedEntries) {
                $j->finalized = true;
            } else {
                $j->finalized = false;
            }
        }

        return view('admin.judges.index', compact('judges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $industryCategories = IndustryCategory::all();
        return view('admin.judges.create', compact('industryCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100|unique:judges',
//            'industry_categories' => 'required',
            'password' => 'required|min:3|max:15|confirmed',
        ]);

        $data = $request->all();

        $judge = Judge::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $judge->save();

        if(!empty($data['industry_categories'])) {
            foreach ($data['industry_categories'] as $ic) {
                $judge->industryCategories()->attach($ic);
            }
        }

        Mail::to($judge->email)->send(new JudgeRegistered($data));
//        $judge->sendEmailVerificationNotification();
        return redirect()->route('admin.judge.index')->with('status', 'Judge created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $judge
     * @return \Illuminate\Http\Response
     */
    public function show(Judge $judge)
    {
        $industryCategories = $judge->industryCategories->pluck('id')->toArray();

        $brands = Brand::whereIn('industry_category_id', $industryCategories)->get();

        $blocked = BlockedEntry::where('judge_id', $judge->id)->get()->pluck('brand_id')->toArray();

        return view('admin.judges.show', compact('brands','judge', 'blocked'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $judge
     * @return \Illuminate\Http\Response
     */
    public function edit(Judge $judge)
    {
        $industryCategories = IndustryCategory::all();
        $selectedIndustryCategories = $judge->industryCategories->pluck('id')->toArray();

        return view('admin.judges.edit', compact('industryCategories',
            'judge', 'selectedIndustryCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $judge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Judge $judge)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100|unique:judges,email,' . $judge->id,
            'industry_categories' => 'required',
        ]);

        $data = $request->all();

        $judge->update($data);

        $judge->industryCategories()->detach();

        foreach ($data['industry_categories'] as $ic) {
            $judge->industryCategories()->attach($ic);
        }

        $blocked = $judge->blockedEntries->pluck('id');
        $allEntries = [];

        foreach ($judge->industryCategories as $ic) {
            $allEntries[] = $ic->brands->pluck('id');
        }


        $temp = [];

        foreach ($allEntries as $e) {
            $temp = array_merge($temp, $e->toArray());
        }

        $allEntries = $temp;

        foreach ($blocked as $b) {
            if(! in_array($b, $allEntries)) {
                $judge->blockedEntries()->whereId($b)->delete();
            }
        }

        return redirect()->route('admin.judge.index')->with('status', 'Judge details updated successfully');
    }


    public function updatePassword(Request $request, Judge $judge)
    {
        $request->validate([
            'password' => 'required|min:3|max:15|alpha_num|confirmed',
        ]);

        $judge->password = Hash::make($request->get('password'));
        $judge->save();

        return redirect()->route('admin.judge.index')->with('status', 'Judge details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $judge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Judge $judge)
    {
        $judge->delete();

        return redirect()->route('admin.judge.index')->with('status', 'Judge deleted successfully');
    }

    public function setBlocked(Request $request)
    {
        $ids = $request->get('ids');

        $judgeId = $request->judgeId;

        BlockedEntry::where('judge_id', $judgeId)->delete();

        if($ids) {
            foreach ($ids as $i) {
                BlockedEntry::create([
                    'judge_id' => $judgeId,
                    'brand_id' => $i,
                ]);
            }
        }

        BrandJudge::whereJudgeId($judgeId)->whereIn('brand_id', $ids)->delete();

        return response()->json('success');
    }

    public function unlock(Request $request)
    {
        $request->validate([
            '_token' => 'required',
            'judgeId' => 'required|numeric'
        ]);

        $judgeId = $request->get('judgeId');

        $currentRound = Flag::first()->current_round;

        BrandJudge::whereJudgeId($judgeId)->whereRound($currentRound)->update(['judge_finalized' => false]);
        CsrScore::whereJudgeId($judgeId)->whereRound($currentRound)->update(['judge_finalized' => false]);

        return response()->json('success');
    }

    public function toggleStatus(Judge $judge)
    {
        if($judge->allowed == true) {
            $judge->allowed = false;
        } else {
            $judge->allowed = true;
        }

        $judge->save();

        return redirect()->back();
    }

    public function blockAllJudges()
    {
        $judges = Judge::all();

        foreach ($judges as $j) {
            $j->allowed = false;
            $j->save();
        }

        return redirect()->back();
    }

    public function allowAllJudges()
    {
        $judges = Judge::all();

        foreach ($judges as $j) {
            $j->allowed = true;
            $j->save();
        }

        return redirect()->back();
    }
}
