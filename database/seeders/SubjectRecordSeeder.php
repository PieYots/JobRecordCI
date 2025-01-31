<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectRecordSeeder extends Seeder
{
    public function run()
    {
        DB::table('subject_records')->insert([
            [
                'topic' => 'Introduction to JavaScript',
                'type' => 'Lecture',
                'reference' => 'ref_001',
                'process' => 'Completed',
                'result' => 'Passed',
                'file_ref' => 'lecture_notes.pdf',
                'rating' => 'A',
                'additional_learning' => 'N/A',
                'e_training_id' => 1,
                'create_at' => now(),
                'record_by' => 1, // John Doe
            ],
        ]);
    }
}
