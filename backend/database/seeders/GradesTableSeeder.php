<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class GradesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('hu_HU');

        $numGradesPerStudent = 2;

        $studentIds = DB::table('students')->pluck('id')->toArray();

        $grades = [];

        foreach ($studentIds as $studentId) {
            for ($i = 0; $i < $numGradesPerStudent; $i++) {
                $grades[] = [
                    'student_id' => $studentId,
                    'grade' => $faker->numberBetween(1, 5),
                    'subject' => $faker->word,
                    'date' => $faker->date,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('grades')->insert($grades);
    }
}
