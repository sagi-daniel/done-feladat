<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateStudentDataSeeder extends Seeder
{
    public function run()
    {
        $this->updateStudentsCount();
        $this->updateGradeAvg();
    }

    private function updateStudentsCount()
    {
        $classes = DB::table('classes')->get();

        foreach ($classes as $class) {
            $studentsCount = DB::table('students')->where('class_id', $class->id)->count();
            DB::table('classes')->where('id', $class->id)->update(['students_count' => $studentsCount]);
        }
    }

    private function updateGradeAvg()
    {
        $students = DB::table('students')->get();

        foreach ($students as $student) {
            $avg = DB::table('grades')
                ->where('student_id', $student->id)
                ->avg('grade');

            if ($avg === null) {
                $avg = 0;
            } else {
                $avg = round($avg, 2);
            }

            DB::table('students')
                ->where('id', $student->id)
                ->update(['grades_avg' => $avg]);
        }
    }
}
