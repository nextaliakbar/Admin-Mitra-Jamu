<?php

namespace Database\Seeders;

use App\Models\PestDisease;
use Illuminate\Database\Seeder;

class PestDiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PestDisease::truncate();
        $csvData = fopen(base_path('database/seeders/csv/pest_diseases.csv'), 'r');
        $header = fgetcsv($csvData);
        while ($row = fgetcsv($csvData)) {
            $data = array_combine($header, $row);
            $pestDisease = PestDisease::create([
                'id' => $data['id'],
                'code' => $data['code'],
                'label' => $data['label'],
                'description' => $data['description'],
                'treatment' => $data['treatment'],
                'day' => $data['day'],
            ]);
            $pestDisease->save();
        }

        fclose($csvData);
    }
}
