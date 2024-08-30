<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->decimal('student_grades_avg', 5, 2)->default(0.00);
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('student_grades_avg');
        });
    }
};
