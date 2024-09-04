<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentModel extends Model
{
    use SoftDeletes;

    protected $table = 'students';


    protected $fillable = [
        'student_name',
        'class_id',
        'student_phone',
        'student_email',
        'student_address',
        'grades_avg',
    ];

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_student', 'student_id', 'class_id');
    }

    public function grades()
    {
        return $this->hasMany(GradeModel::class, 'student_id');
    }

    public function updateGradesAverage()
    {
        $average = $this->grades()->avg('grade') ?? 0;
        $this->update(['grades_avg' => $average]);
    }
}
