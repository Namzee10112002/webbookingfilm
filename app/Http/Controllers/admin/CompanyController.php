<?php

// app/Http/Controllers/Admin/CompanyController.php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\TheaterCompany;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index() {
        $companies = TheaterCompany::orderBy('id','desc')->get();
        return view('admin.pages.companies.index', compact('companies'));
    }

    public function store(Request $r) {
        $data = $r->validate([
            'name_company' => 'required|string|max:255',
            'logo_company' => 'required|string', // cho phép string logo
            'status_company' => 'nullable|in:0,1'
        ]);
        $data['status_company'] = $data['status_company'] ?? 0;
        TheaterCompany::create($data);
        return back()->with('ok','Đã thêm hãng rạp.');
    }

    public function edit(TheaterCompany $company) {
        return view('admin.pages.companies.edit', compact('company'));
    }

    public function update(Request $r, TheaterCompany $company) {
        $data = $r->validate([
            'name_company' => 'required|string|max:255',
            'logo_company' => 'required|string',
            'status_company' => 'nullable|in:0,1'
        ]);
        $company->update($data);
        return redirect()->route('admin.companies.index')->with('ok','Đã cập nhật.');
    }

    public function toggle(TheaterCompany $company) {
        $company->status_company = $company->status_company ? 0 : 1;
        $company->save();
        return back()->with('ok','Đã đổi trạng thái hiển thị.');
    }
}

