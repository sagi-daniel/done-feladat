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
        'student_grades_avg',
        'student_phone',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function grades()
    {
        return $this->hasMany(GradeModel::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function ($student) {
            $student->updateGradesAverage();
        });
    }

    public function updateGradesAverage()
    {
        $average = $this->grades()->avg('grade');
        $this->update(['student_grades_avg' => $average]);
    }
}
