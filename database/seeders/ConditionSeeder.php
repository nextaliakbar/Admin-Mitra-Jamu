<?php

namespace Database\Seeders;

use App\Models\Condition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condition::truncate();
        $csvData = fopen(base_path('database/seeders/csv/conditions.csv'), 'r');
        $header = fgetcsv($csvData);
        while ($row = fgetcsv($csvData)) {
            $data = array_combine($header, $row);
            $condition = Condition::create([
                'code' => $data['code'],
                'status' => $data['status'],
                'value' => $data['value'],
                'treatment' => json_decode($data['treatment']),
                'day' => $data['day'] ?? null,
                'pest_disease_id' => $data['pest_disease_id'] ?? null,
            ]);
            $condition->save();
        }

        fclose($csvData);
    }
}
