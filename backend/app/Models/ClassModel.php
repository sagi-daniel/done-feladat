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
