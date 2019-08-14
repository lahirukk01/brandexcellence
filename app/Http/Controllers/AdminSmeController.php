<?php

namespace App\Http\Controllers;

use App\Judge;
use App\Sme;
use App\SmeJudge;
use Illuminate\Http\Request;

class AdminSmeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $judges = Judge::all();
        $smes = Sme::all();

        foreach ($judges as $j) {
            if(SmeJudge::whereJudgeId($j->id)->count() != 0) {
                $j->isSME = true;
            } else {
                $j->isSME = false;
            }
        }
        return view('admin.sme.index', compact('judges', 'smes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sme.create');
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
            'brand_name' => 'required|max:100',
            'company' => 'required|max:100',
        ]);

        $data = $request->all();
        $data['id_string'] = '2019|SME|' . (Sme::count() + 1);

        Sme::create($data);

        return redirect()->route('admin.sme.index')->with('status', 'SME created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sme  $sme
     * @return \Illuminate\Http\Response
     */
    public function edit(Sme $sme)
    {
        return view('admin.sme.edit', compact('sme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sme  $sme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sme $sme)
    {
        $request->validate([
            'brand_name' => 'required|max:100',
            'company' => 'required|max:100',
        ]);

        $data = $request->all();

        $sme->update($data);

        return redirect()->route('admin.sme.index')->with('status', 'SME updated successfully');
    }

    public function setJudges(Request $request)
    {
        $request->validate([
            'judges' => 'required'
        ]);

        $newJudges = collect($request->judges);

        $judgesInTable = SmeJudge::all()->pluck('judge_id');

        $judgesInTableButNotInNewSet = $judgesInTable->diff($newJudges);

        SmeJudge::whereIn('judge_id', $judgesInTableButNotInNewSet)->delete();
        $judgesInTable = SmeJudge::all()->pluck('judge_id');

        $judgesInNewSetButNotInTable = $newJudges->diff($judgesInTable);

        foreach ($judgesInNewSetButNotInTable as $j) {
            SmeJudge::create(['judge_id' => $j]);
        }

        return redirect()->route('admin.sme.index')->with('status', 'Judges set successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sme  $sme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sme $sme)
    {
        $sme->delete();

        return redirect()->route('admin.sme.index')->with('status', 'SME deleted successfully');
    }
}
