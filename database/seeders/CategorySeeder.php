<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Sarana Produksi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Peralatan Produksi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Bahan Baku',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Bibit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Pupuk',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Obat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Media Tanam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Hasil Panen',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Produk Olahan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
