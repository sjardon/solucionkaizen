<?php

namespace App\Models;

use App\Models\Course\CourseCategory;
use App\Models\Course\CourseStatus;
use App\Models\Image;
use App\Models\Video;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

  // Falta agregar el docente a cargo del curso, pero:
  // ¿El curso puede estar organizado por más de un docente?

  public function category(){
    return $this->belongsTo(CourseCategory::class);
  }

  public function status(){
    return $this->belongsTo(CourseStatus::class);
  }

  public function thumbnailImage(){
    return $this->belongsTo(Image::class,'thumbnail_image_id');
  }

  public function coverImage(){
    return $this->belongsTo(Image::class,'cover_image_id');
  }

  public function presentationVideo(){
    return $this->belongsTo(Video::class,'presentation_video_id');
  }

}
