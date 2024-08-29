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

    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }
}
