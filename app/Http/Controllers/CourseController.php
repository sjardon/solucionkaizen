<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
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
        $courses = Course::all();

        $courses->map(function($course){

          $course->category;
          $course->status;
          $course->thumbnailImage;
          $course->coverImage;
          $course->presentationVideo;

          return $course;
        });

        return response(['courses'=>$courses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      var_dump($request->all());
      // if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
      //   return response('Unauthorized',401);
      // }
      //
      // $validator = Validator::make($request->all(), [
      //   'name' => 'required|unique:courses|max:255',
      //   'category.id' => 'required|exists:course_categories,id',
      //   'status.id' => 'required|exists:course_status,id',
      //   'shortDescription' => 'required|max:255',
      //   'description' => 'required|max:5000',
      //   'price' => 'required',
      //   'thumbnailImage.id' => 'required|exists:images,id',
      //   'coverImage.id' => 'required|exists:images,id',
      //   'presentationVideo.id' => 'required|exists:videos,id'
      //   ])->validate();
      //
      //
      //   $course = Course::create([
      //     'name' => $request->name,
      //     'category' => $request->category->id,
      //     'status' => $request->status->id,
      //     'shortDescription' => $request->shortDescription,
      //     'description' => $request->description,
      //     'price' => $request->price,
      //     'thumbnailImage' => $request->thumbnailImage->id,
      //     'coverImage' => $request->coverImage->id,
      //     'presentationVideo' => $request->presentationVideo->id
      //   ]);
      //
      //   if(!$course){
      //     return response('Error de creación',500);
      //   }
      //
      //   $course->category;
      //   $course->status;
      //   $course->thumbnailImage;
      //   $course->coverImage;
      //   $course->presentationVideo;
      //
      //   return response(["course"=>$course]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
      $course->category;
      $course->status;
      $course->thumbnailImage;
      $course->coverImage;
      $course->presentationVideo;
      return response(["course"=>$course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {

      if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => [
          'required',
          'max:255',
          Rule::unique('courses')->ignore($course)
        ],
        'category.id' => 'required|exists:course_categories,id',
        'status' => 'required',
        'shortDescription' => 'required|max:255',
        'description' => 'required|max:5000',
        'price' => 'required',
        'thumbnailImage.id' => 'required|exists:images,id',
        'coverImage.id' => 'required|exists:images,id',
        'presentationVideo.id' => 'required|exists:videos,id'
        ])->validate();

        $course = new Course([
          'name' => $request->name,
          'category' => $request->category->id,
          'status' => $request->status->id,
          'shortDescription' => $request->shortDescription,
          'description' => $request->description,
          'price' => $request->price,
          'thumbnailImage' => $request->thumbnailImage->id,
          'coverImage' => $request->coverImage->id,
          'presentationVideo' => $request->presentationVideo->id
        ]);

        $course->save();

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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {

      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $course->delete();
      return request("ok");
    }
}
