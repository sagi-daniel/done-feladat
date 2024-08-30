<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeModel extends Model
{
    protected $table = 'grades';

    protected $fillable = [
        'student_id',
        'subject',
        'grade',
        'date',
    ];

    public static function boot()
    {
        parent::boot();

        // Esemény figyelése létrehozáskor, frissítéskor és törléskor
        static::created(function ($grade) {
            $grade->student->updateGradesAverage();
        });

        static::updated(function ($grade) {
            $grade->student->updateGradesAverage();
        });

        static::deleted(function ($grade) {
            $grade->student->updateGradesAverage();
        });
    }

    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }
}
