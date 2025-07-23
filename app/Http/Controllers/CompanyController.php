<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        $results = DB::select("
        SELECT id, company_name, contact, email
        from company
        ");
        return view('company.index',compact('results'));
    }

    public function store (Request $request){
        $validator = \Validator::make(
        $request->all(),
        [
            'company_name' => 'required|string|max:255',
            'contact' => 'required|string|max:100',
            'email' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $company = new Company();
        $company -> company_name = $request -> company_name;
        $company -> contact = $request -> contact;
        $company -> email = $request -> email;
        $company -> save();

        return redirect()->back()->with('success', __('Berhasil Menambah Data Perusahaan'));
    }

    public function update(Request $request, Company $company){
        $validator = \Validator::make(
        $request->all(),
        [
            'company_name' => 'required|string|max:255',
            'contact' => 'required|string|max:100',
            'email' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $company -> company_name = $request -> company_name;
        $company -> contact = $request -> contact;
        $company -> email = $request -> email;
        $company -> save();

        return redirect()->back()->with('success', __('Berhasil Mengubah Data Perusahaan'));
    }

    public function create (){
        return view('company.add');
    }

    public function edit(Company $company){
        return view('company.edit', compact('company'));
    }

}
