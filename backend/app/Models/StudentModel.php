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
        'grades_avg',
        'student_phone',
        'student_address',
    ];

    protected $hidden = ['class_id']; // populated

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
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

    public static function boot()
    {
        parent::boot();

        static::created(function ($student) {
            $student->class->updateStudentsCount();
        });

        static::deleted(function ($student) {
            $student->class->updateStudentsCount();
        });

        static::updated(function ($student) {
            if ($student->isDirty('class_id')) {
                $oldClassId = $student->getOriginal('class_id');
                $newClassId = $student->class_id;

                if ($oldClassId) {
                    $oldClass = ClassModel::find($oldClassId);
                    if ($oldClass) {
                        $oldClass->updateStudentsCount();
                    }
                }

                if ($newClassId) {
                    $newClass = ClassModel::find($newClassId);
                    if ($newClass) {
                        $newClass->updateStudentsCount();
                    }
                }
            }
        });
    }
}
