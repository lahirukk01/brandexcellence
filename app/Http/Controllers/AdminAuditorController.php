<?php

namespace App\Http\Controllers;

use App\Brand;
use App\IndustryCategory;
use App\Auditor;
use App\Mail\AuditorRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminAuditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditors = Auditor::all();

        return view('admin.auditors.index', compact('auditors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.auditors.create');
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
            'email' => 'required|max:100|unique:auditors',
            'contact_number' => 'max:15|digits:10|unique:auditors',
            'password' => 'required|min:3|max:15|confirmed',
        ]);

        $data = $request->all();

        $auditor = Auditor::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'password' => Hash::make($data['password']),
        ]);

        Mail::to($auditor->email)->send(new AuditorRegistered($data));

        return redirect()->route('admin.auditor.index')->with('status', 'Auditor created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $auditor
     * @return \Illuminate\Http\Response
     */
    public function edit(Auditor $auditor)
    {
        return view('admin.auditors.edit', compact('auditor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $auditor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auditor $auditor)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100|unique:auditors,email,' . $auditor->id,
            'contact_number' => 'max:15|digits:10|unique:auditors,contact_number,' . $auditor->id,
        ]);

        $data = $request->all();

        $auditor->update($data);

        return redirect()->route('admin.auditor.index')->with('status', 'Auditor details updated successfully');
    }


    public function updatePassword(Request $request, Auditor $auditor)
    {
        $request->validate([
            'password' => 'required|min:3|max:15|alpha_num|confirmed',
        ]);

        $auditor->password = Hash::make($request->get('password'));
        $auditor->save();

        return redirect()->route('admin.auditor.index')->with('status', 'Auditor details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $auditor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auditor $auditor)
    {
        $auditor->delete();

        return redirect()->route('admin.auditor.index')->with('status', 'Auditor deleted successfully');
    }

    public function toggleStatus(Auditor $auditor)
    {
        if($auditor->allowed == true) {
            $auditor->allowed = false;
        } else {
            $auditor->allowed = true;
        }

        $auditor->save();

        return redirect()->back();
    }

    public function getEntries(Request $request)
    {
        $auditorId = $request->auditorId;

        $brandNames = Brand::whereAuditorId($auditorId)->pluck('name');

        return response()->json($brandNames);
    }
}
