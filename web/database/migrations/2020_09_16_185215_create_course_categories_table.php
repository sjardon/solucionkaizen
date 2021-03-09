<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();

            $table->string("name");

            $table->unsignedBigInteger('parent_course_category_id');

            $table->foreign('parent_course_category_id')
            ->references('id')
            ->on('course_categories')
            ->onDelete('restrict');

            $table->unsignedBigInteger('course_category_status_id');

            $table->foreign('course_category_status_id')
            ->references('id')
            ->on('course_category_statuses')
            ->onDelete('restrict');

            $table->string("short_description");
            $table->text("description");

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
        Schema::dropIfExists('course_categories');
    }
}
