<?php

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c = new Course();
        $c->name = 'Primeros pasos en Ionic';
        $c->category = 1;
        $c->status = 1;
        $c->short_description = 'Descubrí la agilidad de desarrollo de Apps con Ionic.';
        $c->description = 'Ionic está hecho para que no tengas que con tus conocimientos en JavaScript puedas desarrollar de manera muy sencilla Apps para dispositivos móviles. Animate a conocer más y profundizar en esta gran herramienta.';
        $c->price = 3000.00;
        $c->thumbnail_image = 1;
        $c->cover_image = 1;
        $c->presentation_video = 1;
        $c->save();
    }
}
