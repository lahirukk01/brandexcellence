<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Brand;
use App\Category;
use App\IndustryCategory;
use App\Mail\BrandRegistered;
use App\Mail\ClientPayment;
use App\Rules\MaxWords;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
        $industryCategories = IndustryCategory::all();
        $categories = Category::all();
        return view('client.brands.create', compact('categories', 'industryCategories'));
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
            'name' => ['required'],
            'description' => ['required', new MaxWords(60)],
            'category_id' => ['required'],
            'industry_category_id' => ['required'],
            'entry_kit' => 'required|file|mimetypes:application/pdf',
            'logo' => 'required|file',
            'supporting_material' => 'nullable|mimetypes:application/pdf'
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

        if($file3 = $request->file('supporting_material')) {
            $fileName3 = Carbon::now()->format('Y_m_d_H_i_s') . '_' . preg_replace('/\s/', '_', $file3->getClientOriginalName());
            $file3->move('uploads', $fileName3);
            $input['supporting_material'] = $fileName3;
        }

        $categoryCode = Category::findOrFail($input['category_id'])->code;
        $count = Brand::where('category_id', $input['category_id'])->count();
        $count++;
        $count = sprintf('%03d', $count);
        $input['id_string'] = "2019|$categoryCode|$count";


        $company = Auth::user()->company;
        $brand = $company->brands()->create($input);

        $email = Auth::user()->email;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;
        Mail::to($email)->cc($superUserEmail)->send(new BrandRegistered($brand));

        if(!session()->exists('brands')) {
            session()->put('brands', array());
        }

        session()->push('brands', ['name' => $input['name'], 'id' => $input['id_string']]);

        return response()->json(['success'=>'Record added successfully']);
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
        $categories = Category::all();
        $industryCategories = IndustryCategory::all();
        return view('client.brands.edit', compact('brand', 'categories', 'industryCategories'));
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
            'description' => ['required', new MaxWords(60)],
            'category_id' => 'required',
            'industry_category_id' => 'required',
        ]);

        if ($validator->fails()){
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

//        $company = Auth::user()->company;
//        $brand = $company->brands()->create($input);
//
//        $email = Auth::user()->email;
//
//        $superUserEmail = User::where('role_id', 1)->first()->email;
//        Mail::to($email)->cc($superUserEmail)->send(new BrandRegistered($brand));

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

        return redirect()->route('client.brand.index')->with('status', 'Brand deleted successfully');
    }

    public function sendInvoice()
    {
        $user = Auth::user();
        $email = $user->email;

        $superUserEmail = Admin::whereIsSuper(1)->first()->email;

        $data['brands'] = session()->pull('brands');
        $data['clientName'] = $user->name;
        $data['email'] = $user->email;
        $data['contactNumber'] = $user->contact_number;
        $data['companyName'] = $user->company->name;
        $data['companyAddress'] = $user->company->address;
        $data['svat'] = $user->company->svat;
        $data['nbt'] = $user->company->nbt;
        $data['vatNumber'] = $user->company->vat_registration_number;

        Mail::to($email)->cc($superUserEmail)->send(new ClientPayment($data));

        return response()->json(['success'=>'Invoice sent to your email address']);
    }

    public function getNumberOfEntries()
    {
        return count(session()->pull('brands'));
    }
}
