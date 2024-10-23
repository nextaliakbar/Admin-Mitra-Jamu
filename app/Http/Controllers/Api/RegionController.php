<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RegionController extends Controller
{
    public function getProvincies()
    {
      $response = Http::withHeaders([
        'key' => config('services.rajaongkir.key')
      ])->get('https://pro.rajaongkir.com/api/province');

      if ($response->successful()) {
        $provinces = $response->json()['rajaongkir']['results'];

        $formattedProvinces = collect($provinces)->map(function ($province) {
          return [
            'province_id' => $province['province_id'],
            'name' => $province['province'],
          ];
        });

        return response()->json([
          'success' => true,
          'message' => 'Daftar Provinsi',
          'data' => $formattedProvinces
        ]);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Gagal mengambil data provinsi',
        ], 500);
      }
    }

    public function getCities($id)
    {
        $response = Http::withHeaders([
          'key' => config('services.rajaongkir.key')
        ])->get('https://pro.rajaongkir.com/api/city?province=' . $id);

        if($response->successful()) {
          $cities = $response->json()['rajaongkir']['results'];
          $formattedCities = collect($cities)->map(function ($city) {
            return [
              'province_id' => $city['province_id'],
              'city_id' => $city['city_id'],
              'name' => $city['city_name']
            ];
          });

          return response()->json([
            'success' => true,
            'message' => 'Daftar Kabupaten',
            'data' => $formattedCities
          ]);
        } else {
          return response()->json([
            'success' => false,
            'message' => 'Gagal mengambil data provinsi',
          ], 500);
        }
    }

    public function getSubdistricts($id)
    {
        $response = Http::withHeaders([
          'key' => config('services.rajaongkir.key')
        ])->get('https://pro.rajaongkir.com/api/subdistrict?city=' . $id);

        if($response->successful()) {
          $subdistricts = $response->json()['rajaongkir']['results'];
          $formattedSubdistricts = collect($subdistricts)->map(function ($subdistrict) {
            return [
              'province_id' => $subdistrict['province_id'],
              'city_id' => $subdistrict['city_id'],
              'subdistrict_id' => $subdistrict['subdistrict_id'],
              'name' => $subdistrict['subdistrict_name']
            ];
          });

          return response()->json([
            'success' => true,
            'message' => 'Daftar Kecamatan',
            'data' => $formattedSubdistricts
          ]);
        } else {
          return response()->json([
            'success' => false,
            'message' => 'Gagal mengambil data provinsi',
          ], 500);
        }
    }
}
