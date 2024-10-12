<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rule::truncate();
        $csvData = fopen(base_path('database/seeders/csv/rules.csv'), 'r');
        $header = fgetcsv($csvData);
        while ($row = fgetcsv($csvData)) {
            $data = array_combine($header, $row);
            $rule = Rule::create([
                'id' => $data['id'],
                'code' => $data['code'],
                'pest_disease_id' => $data['pest_disease_id'],
            ]);
            $rule->save();
        }

        fclose($csvData);
    }
}
