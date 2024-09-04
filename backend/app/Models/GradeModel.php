<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class GradeModel extends Model
{

    use SoftDeletes;

    protected $table = 'grades';

    protected $fillable = [
        'student_id',
        'subject',
        'grade',
        'class',
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
