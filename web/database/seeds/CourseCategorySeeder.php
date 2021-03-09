<?php

use Illuminate\Database\Seeder;
use App\Models\Course\CourseCategory;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $cc = new CourseCategory();

      $cc->name = 'Programación';
      $cc->parent = null;
      $cc->status = 1;
      $cc->short_description = 'Los mejores cursos de programación ¡En el lenguaje y el paradigma que más te guste!';
      $cc->description = '¿Alguna vez quiciste empezar a programar y no sabías por donde? Aca te mostramos como. ¿Necesitas superarte día a día en tu ambiente laboral pero no tenes tiempo para ir a la facu? Nosotros te exijimos solo lo necesario (aunque vos podes dar demás ;) ). Descubrí las herramientas y metodologías más modernas.';
      $cc->thumbnail_image = 1;
      $cc->cover_image = 1;

      $cc->save();


      $cc = new CourseCategory();

      $cc->name = 'Diseño Gráfico';
      $cc->parent = null;
      $cc->status = 1;
      $cc->short_description = '¡No te quedes sin ideas! ¡Descubrí las mejores práctias y herramientas de diseño!';
      $cc->description = 'El mundo del diseño cada vez toma más valor, y es mejor que estés preparado para poder dar la respuesta de imágen que se espera hoy en día. Te ofrecemos una gran variedad de cursos de diseño para que te profecionalises y rindas mucho más en la transmisión de tus mensajes.';
      $cc->thumbnail_image = 1;
      $cc->cover_image = 1;

      $cc->save();
    }
}
