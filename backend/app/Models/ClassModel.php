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
        'students_count',
    ];

    public function students()
    {
        return $this->hasMany(StudentModel::class, 'class_id');
    }

    public function updateStudentsCount()
    {
        // Frissíti a diákok számát az adott osztályban
        $studentCount = StudentModel::where('class_id', $this->id)->count();
        $this->students_count = $studentCount;
        $this->save();
    }
}
