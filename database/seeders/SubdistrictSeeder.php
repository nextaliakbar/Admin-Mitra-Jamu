<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Subdistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = City::all();

        foreach ($cities as $city) {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key'),
            ])->get('https://pro.rajaongkir.com/api/subdistrict?city=' . $city->city_id);

            if ($response['rajaongkir']['status']['code'] == 200) {
                foreach ($response['rajaongkir']['results'] as $subdistrict) {
                    Subdistrict::create([
                        'subdistrict_id' => $subdistrict['subdistrict_id'],
                        'city_id'      => $city->city_id,
                        'name' => $subdistrict['subdistrict_name'],
                    ]);
                }
            }
        }
    }
}
