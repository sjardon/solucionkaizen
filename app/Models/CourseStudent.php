<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\CourseStudent\CourseStudentStatus;
use App\Models\CourseStudent\SectionStudent;

// Quizá sería más correcto que esto esté en App\Models\Person\Student\Course
// Y las siguientes -> App\Models\Person\Student\Course\Section -> Lesson

class CourseStudent extends Pivot
{

  public function status()
  {
    return $this->belongsTo(CourseStudentStatus::class);
  }

  private function sections()
  {
    return $this->hasMany(SectionStudent::class);
  }

}
