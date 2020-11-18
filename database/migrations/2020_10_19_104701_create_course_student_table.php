<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_student', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('course_id');

            $table->foreign('course_id')
            ->references('id')
            ->on('courses')
            ->onDelete('restrict');

            $table->unsignedBigInteger('student_id');

            $table->foreign('student_id')
            ->references('id')
            ->on('students')
            ->onDelete('restrict');

            $table->unsignedBigInteger('course_student_status_id');

            $table->foreign('course_student_status_id')
            ->references('id')
            ->on('course_student_statuses')
            ->onDelete('restrict');

            //La fecha de inicio se setea cuando el curso pasa al estado "iniciado" o algo similar.
            //No cuando se crea el registro. => no es ->useCurrent()

            $table->date('init_at')->nullable();
            $table->date('end_at')->nullable();

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
        Schema::dropIfExists('course_student');
    }
}
