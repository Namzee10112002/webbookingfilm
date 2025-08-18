<?php

// app/Http/Controllers/Admin/CompanyTheaterController.php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{TheaterCompany, MovieTheater, City};
use Illuminate\Http\Request;

class CompanyTheaterController extends Controller
{
    public function chooseCity(TheaterCompany $company) {
        $cities = City::orderBy('name_city')->get();
        return view('admin.pages.theaters.choose-city', compact('company','cities'));
    }

    public function index(TheaterCompany $company, City $city) {
        $theaters = MovieTheater::withCount('rooms')
            ->where('company_id',$company->id)
            ->where('city_id',$city->id)
            ->orderBy('id','desc')->get();
        return view('admin.pages.theaters.index', compact('company','city','theaters'));
    }

    public function store(Request $r, TheaterCompany $company, City $city) {
        $data = $r->validate([
            'name_theater'    => 'required|max:255',
            'address_theater' => 'required|max:255',
            'image_theater'   => 'required|string',
            'status_theater'  => 'nullable|in:0,1'
        ]);
        $data['company_id'] = $company->id;
        $data['city_id']    = $city->id;
        $data['status_theater'] = $data['status_theater'] ?? 0;
        MovieTheater::create($data);
        return back()->with('ok','Đã thêm rạp cho hãng tại thành phố này.');
    }

    public function edit($company,$city,$theater)
    {
        $theater = MovieTheater::findOrFail($theater);
        $cities = City::all();
        $companies = TheaterCompany::all();

        return view('admin.pages.theaters.edit', compact('theater', 'cities', 'companies'));
    }

    public function update(Request $request,$company,$city,$id)
    {
        $request->validate([
            'image_theater' => 'required|string|max:255',
            'name_theater' => 'required|string|max:255',
            'address_theater' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:theater_companies,id',
        ]);

        $theater = MovieTheater::findOrFail($id);
        $theater->update($request->only('name_theater', 'address_theater','image_theater', 'city_id', 'company_id'));

        return redirect()->route('admin.companies.theaters', [$company,$city])->with('success', 'Cập nhật rạp phim thành công!');
    }

    public function toggle(TheaterCompany $company, City $city, MovieTheater $theater) {
        $theater->status_theater = $theater->status_theater ? 0 : 1;
        $theater->save();
        return back()->with('ok','Đã đổi trạng thái hiển thị.');
    }
}

