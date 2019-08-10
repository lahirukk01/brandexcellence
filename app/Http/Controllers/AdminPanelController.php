<?php

namespace App\Http\Controllers;

use App\Auditor;
use App\Category;
use App\Judge;
use App\Panel;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $panels = Panel::all();
        return view('admin.panels.index', compact('panels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::wherePanelId(null)->get();
        $judges = Judge::all();
        $auditors = Auditor::all();

        return view('admin.panels.create', compact('categories', 'judges', 'auditors'));
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
            'name' => 'required|unique:panels',
            'auditor' => 'required',
            'judges' => 'required',
            'categories' => ['required',
                function($attribute, $value, $fail) {
                    $smeCategoryId = Category::whereCode('SME')->pluck('id')[0];
                    if(is_array($value) && in_array($smeCategoryId, $value) && count($value) > 1) {
                        $fail('SME category should be selected separately');
                    }
                },
            ],
        ]);

        $data['name'] = $request->name;
        $data['auditor_id'] = $request->auditor;

        $panel = Panel::create($data);

        $categoryIds = $request->categories;

        Category::whereIn('id', $categoryIds)->update(['panel_id' => $panel->id]);

        $panel->judges()->attach($request->judges);

        return redirect()->route('admin.panel.index')->with('status', 'Panel created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Panel  $panel
     * @return \Illuminate\Http\Response
     */
    public function show(Panel $panel)
    {
        return view('admin.panels.show', compact('panel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Panel  $panel
     * @return \Illuminate\Http\Response
     */
    public function edit(Panel $panel)
    {
        $auditors = Auditor::all();
        $categories = Category::where('panel_id', $panel->id)->orWhere('panel_id', null)->get();
        $judges = Judge::all();

        $panelJudges = $panel->judges->pluck('id');
        $panelCategories = $panel->categories->pluck('id');
        $panelAuditorId = $panel->auditor->id;

        return view('admin.panels.edit', compact('panelJudges', 'panelCategories',
            'panelAuditorId', 'panel', 'auditors', 'categories', 'judges'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Panel  $panel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Panel $panel)
    {
        $request->validate([
            'name' => 'required|unique:panels,name,' . $panel->id,
            'auditor' => 'required',
            'judges' => 'required',
            'categories' => ['required',
                function($attribute, $value, $fail) {
                    $smeCategoryId = Category::whereCode('SME')->pluck('id')[0];
                    if(is_array($value) && in_array($smeCategoryId, $value) && count($value) > 1) {
                        $fail('SME category should be selected separately');
                    }
                },
            ],
        ]);

        $data['name'] = $request->name;
        $data['auditor_id'] = $request->auditor;

        $panel->update($data);

        $panel->categories()->update(['panel_id' => null]);

        $categoryIds = $request->categories;

        Category::whereIn('id', $categoryIds)->update(['panel_id' => $panel->id]);

        $panel->judges()->detach();
        $panel->judges()->attach($request->judges);

        return redirect()->route('admin.panel.index')->with('status', 'Panel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Panel  $panel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panel $panel)
    {
        $panel->delete();

        return redirect()->route('admin.panel.index')->with('status', 'Panel deleted successfully');
    }
}
