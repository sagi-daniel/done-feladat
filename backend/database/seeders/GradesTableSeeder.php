<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GradesTableSeeder extends Seeder
{
    public function run()
    {
        // Define students and subjects for grades
        $students = range(1, 22);
        $subjects = ['Matematika', 'Fizika', 'Biológia', 'Kémia', 'Történelem', 'Irodalom', 'Földrajz', 'Angol'];

        // Initialize an array to hold the grade data
        $grades = [];

        // Generate 50 grades
        for ($i = 0; $i < 50; $i++) {
            $grades[] = [
                'student_id' => $students[array_rand($students)],
                'subject' => $subjects[array_rand($subjects)],
                'grade' => rand(2, 5),
                'date' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }


        DB::table('grades')->insert($grades);
    }
}
