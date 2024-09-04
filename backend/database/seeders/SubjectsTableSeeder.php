<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['subject_name' => 'Matematika'],
            ['subject_name' => 'Irodalom'],
            ['subject_name' => 'Fizika'],
            ['subject_name' => 'Kémia'],
            ['subject_name' => 'Történelem'],
        ];

        DB::table('subjects')->insert($subjects);
    }
}
