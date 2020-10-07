<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class CourseCategory extends Model
{

  protected $hidden = [
    'parent_course_category_id',
    'course_category_status_id',
    'thumbnail_image_id',
    'cover_image_id'
  ];

  public function parent(){
    return $this->belongsTo(CourseCategory::class,'parent_course_category_id');
  }

  public function status(){
    return $this->belongsTo(CourseStatus::class,'course_category_status_id');
  }

  public function thumbnailImage(){
    return $this->belongsTo(Image::class,'thumbnail_image_id');
  }

  public function coverImage(){
    return $this->belongsTo(Image::class,'cover_image_id');
  }
}
