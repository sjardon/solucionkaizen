<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->id();

            // Mail (está en el usuario), nombre, apellido, foto de perfil, curriculum, sitio web, mini biografía.
            $table->string("name");
            $table->string("surname");
            $table->text("cv")->nullable();
            $table->text("biography")->nullable();

            //Pueden querer compartir varias redes sociales...

            $table->string("web_url",150)->nullable();

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            
            $table->unsignedBigInteger('image_id');

            $table->foreign('image_id')
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
        Schema::dropIfExists('administrators');
    }
}
