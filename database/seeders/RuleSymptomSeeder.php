<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rule_symptoms')->truncate();
        $csvData = fopen(base_path('database/seeders/csv/rule_symptom.csv'), 'r');
        $header = fgetcsv($csvData);
        while ($row = fgetcsv($csvData)) {
            $data = array_combine($header, $row);
            DB::table('rule_symptoms')->insert([
                'rule_id' => $data['rule_id'],
                'symptoms_id' => $data['symptoms_id'],
            ]);
        }

        fclose($csvData);
    }
}
