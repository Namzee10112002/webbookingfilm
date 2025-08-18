<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\TheaterCompany;
use App\Models\MovieTheater;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('id', 'DESC')->get();
        return view('admin.pages.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_city' => 'required|string|max:255|unique:cities,name_city',
        ]);

        City::create([
            'name_city' => $request->name_city,
            'status_city' => 0,
        ]);

        return back()->with('success', 'Thêm thành phố thành công!');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name_city' => 'required|string|max:255'
    ]);

    $city = City::findOrFail($id);
    $city->update([
        'name_city' => $request->name_city
    ]);

    return response()->json(['success' => true]);
}

public function toggle($id)
{
    $city = City::findOrFail($id);
    $city->status_city = $city->status_city ? 0 : 1;
    $city->save();

    return response()->json(['success' => true]);
}

}

