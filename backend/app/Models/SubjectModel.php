<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectModel extends Model
{

    use SoftDeletes;

    protected $table = 'grades';

    public function grades()
    {
        return $this->hasMany(GradeModel::class);
    }
}
