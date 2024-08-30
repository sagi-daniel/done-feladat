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
        'students_count'
    ];

    public function calculateStudentsCount()
    {
        // Diákok számának lekérdezése
        return StudentModel::where('class_id', $this->id)->count();
    }
}
