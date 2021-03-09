<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_teacher', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('course_id');

            $table->foreign('course_id')
            ->references('id')
            ->on('courses')
            ->onDelete('restrict');

            $table->unsignedBigInteger('teacher_id');

            $table->foreign('teacher_id')
            ->references('id')
            ->on('teachers')
            ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_teacher');
    }
}
