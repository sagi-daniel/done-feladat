<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GradesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('grades')->insert([
            [
                'student_id' => 1,
                'subject' => 'Matematika',
                'grade' => 5,
                'date' => '2024-01-15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'student_id' => 1,
                'subject' => 'Fizika',
                'grade' => 4,
                'date' => '2024-02-10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
