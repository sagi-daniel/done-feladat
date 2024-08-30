<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradeModel extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'subject',
        'grade',
        'date',
    ];

    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($grade) {
            $grade->student->updateGradesAverage();
        });

        static::deleted(function ($grade) {
            $grade->student->updateGradesAverage();
        });
    }
}
