<?php

namespace Database\Seeders;

use App\Models\Employment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employment::create([
            'name' => 'Manager',
            'basic_salary' => 2000000,
            'other' => 'Tunjangan Jabatan',
            'description' => 'Manager Mitra Jamur',
        ]);

        Employment::create([
            'name' => 'Staff',
            'basic_salary' => 1000000,
            'other' => 'Tunjangan Jabatan',
            'description' => 'Staff Mitra Jamur',
        ]);

        Employment::create([
            'name' => 'Kasir',
            'basic_salary' => 1000000,
            'other' => 'Tunjangan Jabatan',
            'description' => 'Kasir Mitra Jamur',
        ]);
    }
}
