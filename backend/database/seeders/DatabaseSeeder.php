<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->call([
            ClassesTableSeeder::class,
            StudentsTableSeeder::class,
            SubjectsTableSeeder::class,
            GradesTableSeeder::class,
        ]);
    }
}
