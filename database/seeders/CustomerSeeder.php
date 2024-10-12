<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            'Jember',
            'Banyuwangi',
            'Situbondo',
            'Bondowoso',
            'Lumajang',
        ];

        foreach ($customers as $customer) {
            \App\Models\Customer::create([
                'name' => 'Customer' . $customer,
                'email' => 'user.' . strtolower($customer) . '@gmail.com',
            ]);
        }
    }
}
