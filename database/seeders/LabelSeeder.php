<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_labels')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Baru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_labels')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Terlaris',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_labels')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Diskon',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_labels')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Tersedia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_labels')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Habis',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_labels')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Pre Order',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
