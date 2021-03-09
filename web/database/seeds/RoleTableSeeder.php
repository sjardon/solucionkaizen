<?php

use App\Models\User\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role = new Role();
      $role->name = 'admin';
      $role->description = 'Administrador';
      $role->save();

      $role = new Role();
      $role->name = 'editor';
      $role->description = 'Editor';
      $role->save();

      $role = new Role();
      $role->name = 'docente';
      $role->description = 'Docente';
      $role->save();

      $role = new Role();
      $role->name = 'estudiante';
      $role->description = 'Estudiante';
      $role->save();
    }
}
