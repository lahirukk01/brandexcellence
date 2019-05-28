<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Mail\BrandRegistered;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ClientBrandController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Auth::user()->company->brands;
        return view('client.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('client.brands.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|max:60',
            'category_id' => 'required',
            'entry_kit' => 'required|file|mimetypes:application/pdf',
            'logo' => 'required|file',
        ]);

        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $input = $request->all();
        $file1 = $request->file('entry_kit');
        $file2 = $request->file('logo');

        $fileName1 = Carbon::now()->format('Y_m_d_H_i_s') . '_' . preg_replace('/\s/', '_', $file1->getClientOriginalName());
        $fileName2 = Carbon::now()->format('Y_m_d_H_i_s') . '_' . preg_replace('/\s/', '_', $file2->getClientOriginalName());

        $file1->move('uploads', $fileName1);
        $file2->move('uploads', $fileName2);

        $input['entry_kit'] = $fileName1;
        $input['logo'] = $fileName2;

        $categoryCode = Category::findOrFail($input['category_id'])->code;
        $count = Brand::where('category_id', $input['category_id'])->count();
        $count++;
        $count = sprintf('%03d', $count);
        $input['id_string'] = "2019|$categoryCode|$count";


        $company = Auth::user()->company;
        $brand = $company->brands()->create($input);

        $email = Auth::user()->email;

        $superUserEmail = User::where('role_id', 1)->first()->email;
        Mail::to($email)->cc($superUserEmail)->send(new BrandRegistered($brand));

        return response()->json(['success'=>'Record is successfully added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view('client.brands.view', compact('brand'));
    }


    public function showEntryKit(Brand $brand)
    {
        return response()->file($brand->entry_kit);
    }


    public function showLogo(Brand $brand)
    {
        return response()->download($brand->logo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
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
        //
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

        return redirect('client/brands')->with('status', 'Brand deleted successfully');
    }
}
