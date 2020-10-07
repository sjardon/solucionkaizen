<?php

namespace App\Http\Controllers;

use App\Models\Course\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CourseCategoryController extends Controller
{



    public function __construct(){
      $this->middleware('auth:api', ['only' => ['store','update','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $courseCategories = CourseCategory::all();

      $courseCategories->map(function($courseCategory){

        $courseCategory->parent;
        $courseCategory->status;
        $courseCategory->thumbnailImage;
        $courseCategory->coverImage;

        return $courseCategory;
      });

      return response(['courseCategories'=>$courseCategories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => 'required|unique:course_categories|max:255',
        'parent.id' => 'nullable|exists:course_categories,id',
        'status.id' => 'required|exists:course_category_statuses,id',
        'shortDescription' => 'required|max:255',
        'description' => 'required|max:5000',
        'thumbnailImage.id' => 'required|exists:images,id',
        'coverImage.id' => 'required|exists:images,id',
        ])->validate();


        $courseCategory = CourseCategory([
          'name' => $request->name,
          'shortDescription' => $request->shortDescription,
          'description' => $request->description,
        ]);

        $parent = CourseCategory::find($request->input('parent.id'));
        $status = CourseCategoryStatus::find($request->input('status.id'));
        $thumbnailImage = Image::find($request->input('thumbnailImage.id'));
        $coverImage = Image::find($request->input('coverImage.id'));


        $courseCategory->parent()->associate($parent);
        $courseCategory->status()->associate($status);
        $courseCategory->thumbnailImage()->associate($thumbnailImage);
        $courseCategory->coverImage()->associate($coverImage);

        $courseCategory->save();

        if(!$courseCategory){
          return response('Error de creación',500);
        }


        return response(["courseCategory"=>$courseCategory]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CourseCategory $courseCategory)
    {

      $courseCategory->parent;
      $courseCategory->status;
      $courseCategory->thumbnailImage;
      $courseCategory->coverImage;

      return response(["courseCategory"=>$courseCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseCategory $courseCategory)
    {
      $validator = Validator::make($request->all(), [
        'name' => [
          'required',
          'max:255',
          Rule::unique('course_categories')->ignore($courseCategory)
        ],
        'parent.id' => 'nullable|exists:course_categories,id',
        'status.id' => 'required|exists:course_category_statuses,id',
        'shortDescription' => 'required|max:255',
        'description' => 'required|max:5000',
        'thumbnailImage.id' => 'required|exists:images,id',
        'coverImage.id' => 'required|exists:images,id',
        ])->validate();
        
        $courseCategory = CourseCategory([
          'name' => $request->name,
          'shortDescription' => $request->shortDescription,
          'description' => $request->description,
        ]);

        $parent = CourseCategory::find($request->input('parent.id'));
        $status = CourseCategoryStatus::find($request->input('status.id'));
        $thumbnailImage = Image::find($request->input('thumbnailImage.id'));
        $coverImage = Image::find($request->input('coverImage.id'));


        $courseCategory->parent()->associate($parent);
        $courseCategory->status()->associate($status);
        $courseCategory->thumbnailImage()->associate($thumbnailImage);
        $courseCategory->coverImage()->associate($coverImage);

        $courseCategory->save();
        if(!$course){
          return response('Error de creación',500);
        }

        $course->category;
        $course->status;
        $course->thumbnailImage;
        $course->coverImage;
        $course->presentationVideo;

        return response(["course"=>$course]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseCategory $courseCategory)
    {
      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $courseCategory->delete();
      return request("ok");
    }
}
