<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $students = [
            ['Tóth Ádám', 1, '+36123456789'],
            ['Kovács Éva', 1, '+36123456780'],
            ['Nagy László', 1, '+36123456781'],
            ['Farkas Júlia', 1, '+36123456782'],
            ['Szabó Gábor', 1, '+36123456783'],
            ['Kiss Anna', 1, '+36123456784'],
            ['Varga Zoltán', 2, '+36123456785'],
            ['Péter István', 2, '+36123456786'],
            ['Bodnár Rita', 2, '+36123456787'],
            ['Sárközi János', 2, '+36123456788'],
            ['Molnár Klára', 2, '+36123456789'],
            ['Németh Lili', 2, '+36123456790'],
            ['Fekete Balázs', 3, '+36123456791'],
            ['Kovács Márton', 3, '+36123456792'],
            ['Kis Emese', 3, '+36123456793'],
            ['Lukács Katalin', 3, '+36123456794'],
            ['Juhász Péter', 3, '+36123456795'],
            ['Varga Gábor', 3, '+36123456796'],
            ['Tóth Zoltán', 3, '+36123456797'],
            ['Kovács László', 3, '+36123456798'],
            ['Gulyás Eszter', 3, '+36123456799'],
            ['Rácz Anna', 3, '+36123456800'],
        ];

        foreach ($students as $student) {
            DB::table('students')->insert([
                'student_name' => $student[0],
                'class_id' => $student[1],
                'student_phone' => $student[2],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
