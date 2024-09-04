<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ClassesTableSeeder::class,
            StudentsTableSeeder::class,
            SubjectsTableSeeder::class,
            GradesTableSeeder::class,
        ]);
    }
}
