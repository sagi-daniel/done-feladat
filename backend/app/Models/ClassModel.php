<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use SoftDeletes;

    protected $table = 'classes';


    protected $fillable = [
        'class_name',
        'classroom',
        'teacher',
        'teacher_email',
    ];

    public function students()
    {
        return $this->belongsToMany(StudentModel::class, 'class_student', 'class_id', 'student_id');
    }
}
