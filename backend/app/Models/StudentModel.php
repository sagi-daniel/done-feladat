<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{

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
}
