<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GradesTableSeeder extends Seeder
{
    public function run()
    {
        $subjects = ['Matematika', 'Fizika', 'Kémia', 'Biológia', 'Történelem', 'Irodalom', 'Angol', 'Francia', 'Számítástechnika', 'Földrajz'];
        $students = range(1, 10); // Példa student_id-k 1-től 10-ig

        $grades = [];
        for ($i = 0; $i < 50; $i++) {
            $grades[] = [
                'student_id' => $students[array_rand($students)],
                'subject' => $subjects[array_rand($subjects)],
                'grade' => rand(1, 5),
                'date' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }


        DB::table('grades')->insert($grades);
    }
}
