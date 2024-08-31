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
        $faker = Faker::create();

        // Minden diákhoz 5 érdemjegyet rendelünk
        $numGradesPerStudent = 2;


        $studentIds = DB::table('students')->pluck('id')->toArray();

        $grades = [];

        foreach ($studentIds as $studentId) {
            for ($i = 0; $i < $numGradesPerStudent; $i++) {
                $grades[] = [
                    'student_id' => $studentId,
                    'grade' => $faker->numberBetween(1, 5), // Érdemjegy 1 és 5 között
                    'subject' => $faker->word, // Új mező hozzáadása
                    'date' => $faker->date, // Új mező hozzáadása
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('grades')->insert($grades);
    }
}
