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
        'subject_id',
        'grade',
        'date',
    ];


    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id');
    }

    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }
}
