<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class DependentDropdownController extends Controller
{
    public function index()
    {
        $provinces = Province::pluck('name', 'code');
        return view('user::dependent-dropdown.index', [
            'provinces' => $provinces,
        ]);
    }

    public function store(Request $request)
    {
        $cities = City::where('province_code', $request->get('id'))
            ->pluck('name', 'code');
        return response()->json($cities);
    }

    public function kecamatan(Request $request)
    {
        $kecamatan = District::where('city_code', $request->get('id'))
            ->pluck('name', 'code');
        return response()->json($kecamatan);
    }

    public function desa(Request $request)
    {
        $kecamatan = Village::where('district_code', $request->get('id'))
            ->pluck('name', 'code');
        return response()->json($kecamatan);
    }
}
