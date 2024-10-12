<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\Subdistrict;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function getProvincies()
    {
        $getProvince = Province::all();

        if (!$getProvince) {
            return response()->json([
                'success' => false,
                'message' => 'Daftar Provinsi',
                'data'    => 'Tidak ada data'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Provinsi',
            'data'    => $getProvince
        ]);
    }

    public function getCities($id)
    {
        $getCity = City::where('province_id', $id)->get();

        if (!$getCity) {
            return response()->json([
                'success' => false,
                'message' => 'Daftar Kota',
                'data'    => 'Tidak ada data'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Kota',
            'data'    => $getCity
        ]);
    }

    public function getSubdistricts($id)
    {
        $getSubdistrict = Subdistrict::where('city_id', $id)->get();

        if (!$getSubdistrict) {
            return response()->json([
                'success' => false,
                'message' => 'Daftar Kecamatan',
                'data'    => 'Tidak ada data'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Kecamatan',
            'data'    => $getSubdistrict
        ]);
    }
}
