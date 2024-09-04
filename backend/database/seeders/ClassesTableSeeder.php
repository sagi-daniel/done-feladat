<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;
use App\Models\StudentModel;
use Faker\Factory as Faker;

class ClassesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('hu_HU');
        $classes = [];

        for ($i = 0; $i < 30; $i++) {
            $classes[] = ClassModel::create([
                'class_name' => $faker->word . ' ' . $faker->numberBetween(100, 999),
                'classroom' => $faker->numberBetween(100, 1000),
                'teacher' => $faker->name,
                'teacher_email' => $faker->unique()->safeEmail,
            ]);
        }

        // Kapcsolatok beszúrása a pivot táblába
        foreach ($classes as $class) {
            $students = StudentModel::inRandomOrder()->take(rand(10, 20))->pluck('id');
            $class->students()->attach($students);
        }
    }
}
