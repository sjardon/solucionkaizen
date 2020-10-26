<?php

namespace App\Models\CourseStudent;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\CourseStudent\SectionStudent\SectionStudentStatus;
use App\Models\CourseStudent\SectionStudent\LessonStudent;

class SectionStudent extends Pivot
{

  public function status()
  {
    return $this->belongsTo(SectionStudentStatus::class);
  }

  private function lessons()
  {
    return $this->hasMany(LessonStudent::class);
  }

}
