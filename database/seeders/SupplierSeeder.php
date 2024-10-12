<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'PT. Mitra Jamur Indonesia',
            'email' => 'info@mitrajamur.com',
            'phone' => '0877-6276-4999',
            'address' => 'Jl. Merak No.64, Kedawung Kidul, Gebang, Kec. Patrang, Kabupaten Jember, Jawa Timur 68117',
            'avatar' => 'https://lh5.googleusercontent.com/-gly38FblWoI/AAAAAAAAAAI/AAAAAAAAAAA/2sRNjkxhCEA/s44-p-k-no-ns-nd/photo.jpg',
            'status' => 'active',
            'type' => 'internal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
