<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_student', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('section_id');

            $table->foreign('section_id')
            ->references('id')
            ->on('sections')
            ->onDelete('restrict');

            $table->unsignedBigInteger('course_student_id');

            $table->foreign('course_student_id')
            ->references('id')
            ->on('course_student')
            ->onDelete('restrict');

            $table->unsignedBigInteger('section_student_status_id');

            $table->foreign('section_student_status_id')
            ->references('id')
            ->on('section_student_statuses')
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
        Schema::dropIfExists('section_student');
    }
}
