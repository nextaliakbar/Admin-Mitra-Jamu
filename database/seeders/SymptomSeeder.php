<?php

namespace Database\Seeders;

use App\Models\Symptoms;
use Illuminate\Database\Seeder;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Symptoms::truncate();
        $csvData = fopen(base_path('database/seeders/csv/symptoms.csv'), 'r');
        $header = fgetcsv($csvData);
        while ($row = fgetcsv($csvData)) {
            $data = array_combine($header, $row);
            $symptom = Symptoms::create([
                'id' => $data['id'],
                'code' => $data['code'],
                'label' => $data['label'],
            ]);
            $symptom->save();
        }

        fclose($csvData);
    }
}
