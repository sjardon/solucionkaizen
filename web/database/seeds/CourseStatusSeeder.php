<?php

use Illuminate\Database\Seeder;
use App\Models\Course\CourseStatus;


class CourseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $cs = new CourseStatus();
      $cs->name = 'creation';
      $cs->description = 'Creación';
      $cs->order = 1;
      $cs->default = true;
      $cs->active = true;
      $cs->save();

      $cs = new CourseStatus();
      $cs->name = 'revision';
      $cs->description = 'Revisión';
      $cs->order = 2;
      $cs->default = true;
      $cs->active = true;
      $cs->save();

      $cs = new CourseStatus();
      $cs->name = 'updating';
      $cs->description = 'Actualización';
      $cs->order = 3;
      $cs->default = true;
      $cs->active = true;
      $cs->save();

      $cs = new CourseStatus();
      $cs->name = 'public';
      $cs->description = 'Público';
      $cs->order = 4;
      $cs->default = true;
      $cs->active = true;
      $cs->save();

      $cs = new CourseStatus();
      $cs->name = 'closed';
      $cs->description = 'Cerrado';
      $cs->order = 5;
      $cs->default = true;
      $cs->active = true;
      $cs->save();
    }
}
