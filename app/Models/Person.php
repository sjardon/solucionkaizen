<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Person extends Model
{
  protected $fillable = [
      'name', 'surname'
  ];
}
