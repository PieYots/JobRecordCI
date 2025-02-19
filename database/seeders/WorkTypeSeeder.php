<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkType;
use App\Models\WorkTypeCriteria;

class WorkTypeSeeder extends Seeder
{
    public function run()
    {
        // Kaizen Work Types
        $kaizenTypes = [
            ['name' => 'Karakuri', 'has_criteria' => false],
            ['name' => 'Other Kaizen', 'has_criteria' => true],
        ];

        foreach ($kaizenTypes as $type) {
            $workType = WorkType::create(array_merge(['category' => 'Kaizen'], $type));

            if ($type['has_criteria']) {
                WorkTypeCriteria::create(['work_type_id' => $workType->id, 'name' => 'Criteria Example']);
            }
        }

        // OE Work Types
        $oeTypes = [
            ['name' => 'Process Improvement', 'has_criteria' => false],
            ['name' => 'Standardization', 'has_criteria' => false],
        ];

        foreach ($oeTypes as $type) {
            WorkType::create(array_merge(['category' => 'OE'], $type));
        }
    }
}
