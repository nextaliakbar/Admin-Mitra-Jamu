<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::withHeaders([
            'key' => config('services.rajaongkir.key'),
        ])->get('https://pro.rajaongkir.com/api/city');

        foreach ($response['rajaongkir']['results'] as $city) {
            City::create([
                'province_id' => $city['province_id'],
                'city_id'     => $city['city_id'],
                'name'        => $city['city_name'],
                'type'        => $city['type'],
                'postal_code' => $city['postal_code'],
            ]);
        }
    }
}
