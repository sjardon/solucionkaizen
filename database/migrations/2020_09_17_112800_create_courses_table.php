<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            //          FALTA VER COMO IMPLEMENTAR LA PUNTUACIÓN!!!
            // Nombre,
            // descripción mínima,
            // descripción completa,
            // programa (Secciones y clases),
            // imagen miniatura (1:1),
            // imagen portada (16:9),
            // video de presentación,
            // categoría,
            // Evaluación del curso -> puntuación y encuesta
            // precio.

            $table->string("name");

            $table->unsignedBigInteger('course_category_id');

            $table->foreign('course_category_id')
            ->references('id')
            ->on('course_categories')
            ->onDelete('restrict');

            $table->unsignedBigInteger('course_status_id');

            $table->foreign('course_status_id')
            ->references('id')
            ->on('course_statuses')
            ->onDelete('restrict');

            $table->string("short_description");
            $table->text("description");
            $table->double('price', 10, 2);

            $table->unsignedBigInteger('thumbnail_image_id');

            $table->foreign('thumbnail_image_id')
            ->references('id')
            ->on('images')
            ->onDelete('restrict');

            $table->unsignedBigInteger('cover_image_id');

            $table->foreign('cover_image_id')
            ->references('id')
            ->on('images')
            ->onDelete('restrict');

            $table->unsignedBigInteger('presentation_video_id');

            $table->foreign('presentation_video_id')
            ->references('id')
            ->on('videos')
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
        Schema::dropIfExists('courses');
    }
}
