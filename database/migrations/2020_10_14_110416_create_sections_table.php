<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();

            $table->string("name");
            $table->string("description");
            $table->integer("order");

            $table->unsignedBigInteger('course_id');

            $table->foreign('course_id')
            ->references('id')
            ->on('courses')
            ->onDelete('restrict');

            $table->unsignedBigInteger('section_status_id');

            $table->foreign('section_status_id')
            ->references('id')
            ->on('section_statuses')
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
        Schema::dropIfExists('sections');
    }
}
