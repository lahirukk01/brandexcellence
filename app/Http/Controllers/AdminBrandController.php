<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\IndustryCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AdminBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id_string')->get();
        return view('admin.brands.index', compact('brands'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $categories = Category::all();
        $industryCategories = IndustryCategory::all();
        return view('admin.brands.edit', compact('brand', 'categories', 'industryCategories'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'required|max:60',
            'category_id' => 'required',
            'industry_category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $input = $request->all();

        if( empty($input['entry_kit'])) {
            unset($input['entry_kit']);
        }

        if( empty($input['logo'])) {
            unset($input['logo']);
        }

        $oldEntryKit = $brand->entry_kit;
        $oldLogo = $brand->logo;

        if( $request->file('entry_kit') != null && $request->file('entry_kit')->isValid() ) {
            $file1 = $request->file('entry_kit');
            $fileName1 = Carbon::now()->format('Y_m_d_H_i_s') . '_' . preg_replace('/\s/', '_', $file1->getClientOriginalName());
            $file1->move('uploads', $fileName1);
            $input['entry_kit'] = $fileName1;
        }

        if( $request->file('logo') != null && $request->file('logo')->isValid() ) {
            $file2 = $request->file('logo');
            $fileName2 = Carbon::now()->format('Y_m_d_H_i_s') . '_' . preg_replace('/\s/', '_', $file2->getClientOriginalName());
            $file2->move('uploads', $fileName2);
            $input['logo'] = $fileName2;
        }

        $categoryCode = Category::findOrFail($input['category_id'])->code;
        $count = Brand::where('category_id', $input['category_id'])->count();
        $count++;
        $count = sprintf('%03d', $count);
        $input['id_string'] = "2019|$categoryCode|$count";

        $brand->update($input);

        if( isset($input['entry_kit']) ) {
            File::delete($oldEntryKit);
        }

        if( isset($input['logo']) ) {
            File::delete($oldLogo);
        }

        return response()->json(['success'=>'Brand updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('status', 'Brand deleted successfully');
    }

    public function setOptions(Request $request)
    {
        $ids = $request->get('ids');

        foreach ($ids as $i) {
            Brand::where('id', $i[0])->update(['show_options' => $i[1]]);
        }

//        return response()->json(['success'=> $ids[0][0]]);
        return response()->json(['success'=>'Brand access levels for clients set successfully']);
    }
}
