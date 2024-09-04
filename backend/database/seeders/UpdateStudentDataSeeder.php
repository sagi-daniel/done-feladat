<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;
use App\Models\StudentModel;

class UpdateStudentDataSeeder extends Seeder
{
    public function run()
    {
        $this->updateGradeAvg();
    }


    private function updateGradeAvg()
    {
        $students = StudentModel::all();

        foreach ($students as $student) {
            $avg = $student->grades()->avg('grade');

            if ($avg === null) {
                $avg = 0;
            } else {
                $avg = round($avg, 2);
            }

            $student->grades_avg = $avg;
            $student->save();
        }
    }
}
