<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Image;

abstract class Person extends Model
{
  protected $fillable = [
      'name', 'surname'
  ];

  public function user(){
    // La persona debería de poder cargar el usuario? No debería ser solo user->person ?
    return $this->belongsTo(User::class);
  }

  public function image(){
    return $this->belongsTo(Image::class);
  }
}
