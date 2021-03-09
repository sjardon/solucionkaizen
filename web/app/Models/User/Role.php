<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  public function users()
  {
    return $this->belongsToMany(User::class)->withTimestamps();
  }

}
