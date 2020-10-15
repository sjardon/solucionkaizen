<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();

            $table->string("name");
            $table->text("description");
            $table->integer("order");

            $table->unsignedBigInteger('section_id');

            $table->foreign('section_id')
            ->references('id')
            ->on('sections')
            ->onDelete('restrict');

            $table->unsignedBigInteger('video_id');

            $table->foreign('video_id')
            ->references('id')
            ->on('videos')
            ->onDelete('restrict');

            $table->integer("order");

            $table->unsignedBigInteger('lesson_status_id');

            $table->foreign('lesson_status_id')
            ->references('id')
            ->on('lesson_statuses')
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
        Schema::dropIfExists('lessons');
    }
}
