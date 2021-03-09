<?php

namespace App\Models;

use App\Models\Course\CourseCategory;
use App\Models\Course\CourseStatus;
use App\Models\Image;
use App\Models\Video;
use App\Models\Person\Teacher;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

  protected $hidden = [
    'course_category_id',
    'course_status_id',
    'thumbnail_image_id',
    'cover_image_id',
    'presentation_video_id'
  ];

  protected $fillable = [
    'name',
    'category',
    'status',
    'short_description',
    'description',
    'price',
    'thumbnail_image',
    'cover_image',
    'presentation_video'
  ];



  public function teachers(){
    return $this->belongsToMany(Teacher::class)->withTimestamps()->as('assign');
  }

  public function category(){
    return $this->belongsTo(CourseCategory::class,'course_category_id');
  }

  public function status(){
    return $this->belongsTo(CourseStatus::class,'course_status_id');
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
