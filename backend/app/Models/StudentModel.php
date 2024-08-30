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
    ];

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
        // Számolja ki az átlagot, ha nincs jegy, állítsa null-ra
        $average = $this->grades()->avg('grade') ?? 0;

        // Frissítse az adatbázis rekordot
        $this->update(['grades_avg' => $average]);
    }
}
