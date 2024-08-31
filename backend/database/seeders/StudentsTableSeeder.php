<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Az osztályok azonosítói
        $classIds = range(1, 25);

        $students = [];
        $numStudents = rand(400, 500);

        for ($i = 0; $i < $numStudents; $i++) {
            $students[] = [
                'student_name' => $faker->name,
                'class_id' => $classIds[array_rand($classIds)], // Véletlenszerűen osztály azonosító
                'student_phone' => $faker->phoneNumber,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('students')->insert($students);
    }
}
