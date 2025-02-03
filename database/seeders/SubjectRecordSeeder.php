<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectRecordSeeder extends Seeder
{
    public function run()
    {
        // Insert a course type record if it doesn't already exist
        DB::table('course_types')->insert([
            'id' => 1, // Ensure this ID exists, or adjust accordingly
            'course_name' => 'Basic Programming', // Change to your desired course name
        ]);
        DB::table('subject_records')->insert([
            [
                'topic' => 'Introduction to JavaScript',
                'course_type_id' => 1,
                'reference' => 'ref_001',
                'process' => 'Completed',
                'result' => 'Passed',
                'file_ref' => 'lecture_notes.pdf',
                'rating' => 3,
                'additional_learning' => 'N/A',
                'e_training_id' => 1,
                'create_at' => now(),
                'record_by' => 1, // John Doe
                'start_date' => now(), // Set start date
                'end_date' => now()->addDays(7),
            ],
        ]);
    }
}
