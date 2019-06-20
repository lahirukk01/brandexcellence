<?php

namespace App\Http\Controllers;

use App\BlockedEntry;
use App\Brand;
use App\IndustryCategory;
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
        $judges = User::where('role_id', 3)->get();

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
            'name' => 'required|max:100|unique:users',
            'email' => 'required|max:100|unique:users',
            'contact_number' => 'max:15|digits:10|unique:users',
            'password' => 'required|min:3|max:15|confirmed',
        ]);

        $data = $request->all();

        $judge = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'password' => Hash::make($data['password']),
        ]);

        $judge->role_id = 3;
        $judge->save();

        foreach ($data['industry_categories'] as $ic) {
            $judge->industryCategories()->attach($ic);
        }

        Mail::to($judge->email)->send(new JudgeRegistered($data));
        return redirect()->route('admin.judges.index')->with('status', 'Judge created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $judge
     * @return \Illuminate\Http\Response
     */
    public function show(User $judge)
    {
        $industryCategories = $judge->industryCategories->pluck('id')->toArray();

        $brands = Brand::whereIn('industry_category_id', $industryCategories)->get();

        $blocked = BlockedEntry::where('user_id', $judge->id)->get()->pluck('brand_id')->toArray();

        return view('admin.judges.show', compact('brands','judge', 'blocked'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $judge
     * @return \Illuminate\Http\Response
     */
    public function edit(User $judge)
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
    public function update(Request $request, User $judge)
    {
        $request->validate([
            'name' => 'required|max:100|unique:users,name,' . $judge->id,
            'email' => 'required|max:100|unique:users,email,' . $judge->id,
            'contact_number' => 'max:15|digits:10|unique:users,contact_number,' . $judge->id,
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

        return redirect()->route('admin.judges.index')->with('status', 'Judge details updated successfully');
    }


    public function updatePassword(Request $request, User $judge)
    {
        $request->validate([
            'password' => 'required|min:3|max:15|alpha_num|confirmed',
        ]);

        $judge->password = Hash::make($request->get('password'));

        return redirect()->route('admin.judges.index')->with('status', 'Judge details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $judge
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $judge)
    {
        $judge->delete();

        return redirect()->route('admin.judges.index')->with('status', 'Judge deleted successfully');
    }

    public function setBlocked(Request $request)
    {
        $ids = $request->get('ids');

        $judgeId = $request->get('judgeId');

        BlockedEntry::where('user_id', $judgeId)->delete();

        foreach ($ids as $i) {
            BlockedEntry::create([
                'user_id' => $judgeId,
                'brand_id' => $i,
            ]);
        }

        return response()->json(['success'=>'Blocked entries for the judge set successfully']);
    }
}
