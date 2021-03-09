<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_student', function (Blueprint $table) {
          $table->id();

          $table->unsignedBigInteger('lesson_id');

          $table->foreign('lesson_id')
          ->references('id')
          ->on('lessons')
          ->onDelete('restrict');

          $table->unsignedBigInteger('lesson_student_id');

          $table->foreign('lesson_student_id')
          ->references('id')
          ->on('lesson_student')
          ->onDelete('restrict');

          $table->unsignedBigInteger('lesson_student_status_id');

          $table->foreign('lesson_student_status_id')
          ->references('id')
          ->on('lesson_student_statuses')
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
        Schema::dropIfExists('lesson_student');
    }
}
