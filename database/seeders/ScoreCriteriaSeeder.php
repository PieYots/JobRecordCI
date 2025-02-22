<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert default score criteria records
        DB::table('score_criteria')->insert([
            [
                'score' => 5,
                'description' => 'Criteria 1: S-TPM Record OJT and E-Training present',
            ],
            [
                'score' => 4,
                'description' => 'Criteria 2: S-TPM Record Either OJT or E-Training present',
            ],
            [
                'score' => 3,
                'description' => 'Criteria 3: S-TPM Record Neither OJT nor E-Training present',
            ],
            [
                'score' => 5,
                'description' => 'Criteria 1: Course Record OJT and E-Training present',
            ],
            [
                'score' => 4,
                'description' => 'Criteria 2: Course Record Either OJT or E-Training present',
            ],
            [
                'score' => 3,
                'description' => 'Criteria 3: Course Record Neither OJT nor E-Training present',
            ],
            [
                'score' => 1,
                'description' => 'Record On Job Training (OJT)',
            ],
            [
                'score' => 50,
                'description' => 'Record OPL with Paper',
            ],
            [
                'score' => 100,
                'description' => 'Record OPL with Video',
            ],
            [
                'score' => 100,
                'description' => 'Record Improvement with Paper',
            ],
            [
                'score' => 200,
                'description' => 'Record Improvement with Video',
            ],
        ]);
    }
}
