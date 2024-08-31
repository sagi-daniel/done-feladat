<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ClassesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $classes = [];
        $numClasses = 30;

        for ($i = 0; $i < $numClasses; $i++) {
            $classes[] = [
                'class_name' => $faker->word . ' ' . $faker->numberBetween(100, 999),
                'classroom' => $faker->numberBetween(100, 3000),
                'teacher' => $faker->name,
                'teacher_email' => $faker->unique()->safeEmail,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('classes')->insert($classes);
    }
}
