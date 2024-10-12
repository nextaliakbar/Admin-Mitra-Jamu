<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
            LabelSeeder::class,
            SupplierSeeder::class,
            // ProductSeeder::class,
            EmploymentSeeder::class,
            // ProvinceSeeder::class,
            // CitySeeder::class,
            // SubdistrictSeeder::class,
            PestDiseaseSeeder::class,
            ConditionSeeder::class,
            RuleSeeder::class,
            SymptomSeeder::class,
            RuleSymptomSeeder::class,
        ]);
    }
}
