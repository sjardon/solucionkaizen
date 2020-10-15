<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Course\Section\Lesson;
use App\Models\Course\Section\SectionStatus;

class Section extends Model
{


  public function course(){
    return $this->belongsTo(Course::class);
  }

  public function lessons(){
    return $this->hasMany(Lesson::class);
  }

  public function status(){
    return $this->belongsTo(SectionStatus::class);
  }

}
