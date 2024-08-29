<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'classroom',
        'teacher',
        'teacher_email',
        'students_count'
    ];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($class) {
            $class->students_count = $class->calculateStudentsCount();
            $class->save();
        });
    }

    private function calculateStudentsCount()
    {
        // Diákok számának lekérdezése
        return StudentModel::where('class_id', $this->id)->count();
    }
}
