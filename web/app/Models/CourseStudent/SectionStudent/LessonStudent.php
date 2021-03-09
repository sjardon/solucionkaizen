<?php

namespace App\Models\CourseStudent\SectionStudent;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\CourseStudent\SectionStudent\LessonStudentStatus;

class LessonStudent extends Pivot
{

  public function status()
  {
    return $this->belongsTo(LessonStudentStatus::class);
  }

}
