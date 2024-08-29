<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('classes')->insert([
            [
                'class_name' => 'Matematika 101',
                'classroom' => 101,
                'teacher' => 'Kiss Péter',
                'teacher_email' => 'kiss.peter@example.com',
                'students_count' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'class_name' => 'Fizika 202',
                'classroom' => 202,
                'teacher' => 'Nagy Anna',
                'teacher_email' => 'nagy.anna@example.com',
                'students_count' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'class_name' => 'Biológia 303',
                'classroom' => 303,
                'teacher' => 'Szabó Zoltán',
                'teacher_email' => 'szabo.zoltan@example.com',
                'students_count' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
