<?php

namespace App\Models\Course\Section;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course\Section;
use App\Models\Video;
use App\Models\Course\Section\Lesson\LessonStatus;

class Lesson extends Model
{

  public function status(){
    return $this->belongsTo(LessonStatus::class);
  }

  public function video(){
    return $this->belongsTo(Video::class);
  }
}
