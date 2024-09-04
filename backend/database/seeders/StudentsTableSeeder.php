<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\ClassModel;
use App\Models\StudentModel;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('hu_HU');

        // Az osztályok azonosítói
        $classIds = ClassModel::pluck('id')->toArray();

        // Diákok beszúrása
        $students = [];
        $numStudents = rand(400, 500);

        for ($i = 0; $i < $numStudents; $i++) {
            $classId = $classIds[array_rand($classIds)];

            $students[] = [
                'student_name' => $faker->name,
                'class_id' => $classId,
                'student_phone' => $faker->phoneNumber,
                'student_email' => $faker->unique()->safeEmail,
                'student_address' => $faker->streetAddress,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Diákok beszúrása
        DB::table('students')->insert($students);

        // Diákok és osztályok közötti kapcsolatok frissítése
        $students = DB::table('students')->get(); // Lekérjük az újonnan beszúrt diákokat

        foreach ($students as $student) {
            $class = ClassModel::find($student->class_id);
            if ($class) {
                $class->students()->attach($student->id);
            }
        }
    }
}
