<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Models\Subdistrict;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function getProvince()
    {
        $provincies = Province::all();

        return response()->json([
            'status' => 'success',
            'data' => $provincies
        ], 200);
    }

    public function getCity($province_id)
    {
        $cities = City::where('province_id', $province_id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $cities
        ], 200);
    }

    public function getSubdistrict($city_id)
    {
        $subdistricts = Subdistrict::where('city_id', $city_id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $subdistricts
        ], 200);
    }
}
