<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Models\Course\CourseCategory;
use App\Models\Course\CourseStatus;
use App\Models\Image;
use App\Models\Video;

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

        $courses = Course::with('teachers')
        ->with('category')
        ->with('status')
        ->with('thumbnailImage')
        ->with('coverImage')
        ->with('presentationVideo')
        ->get();

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

      if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => 'required|unique:courses|max:255',
        'category.id' => 'required|exists:course_categories,id',
        'status.id' => 'required|exists:course_statuses,id',
        'shortDescription' => 'required|max:255',
        'description' => 'required|max:5000',
        'price' => 'required',
        'thumbnailImage.id' => 'required|exists:images,id',
        'coverImage.id' => 'required|exists:images,id',
        'presentationVideo.id' => 'required|exists:videos,id'
        ])->validate();

        $course = new Course([
          'name' => $request->input('name'),
          'short_description' => $request->input('shortDescription'),
          'description' => $request->input('description'),
          'price' => $request->input('price'),
        ]);

        $cc = CourseCategory::find($request->input('category.id'));
        $cs = CourseStatus::find($request->input('status.id'));
        $ti = Image::find($request->input('thumbnailImage.id'));
        $ci = Image::find($request->input('coverImage.id'));
        $pv = Video::find($request->input('presentationVideo.id'));

        $course->category()->associate($cc);
        $course->status()->associate($cs);
        $course->thumbnailImage()->associate($ti);
        $course->coverImage()->associate($ci);
        $course->presentationVideo()->associate($pv);

        $course->save();

        if(!$course){
          return response('Error de creación',500);
        }

        return response(["course"=>$course]);
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

        $course->name = $request->input('name');
        $course->short_description = $request->input('shortDescription');
        $course->description = $request->input('description');
        $course->price = $request->input('price');

        $cc = CourseCategory::find($request->input('category.id'));
        $cs = CourseStatus::find($request->input('status.id'));
        $ti = Image::find($request->input('thumbnailImage.id'));
        $ci = Image::find($request->input('coverImage.id'));
        $pv = Video::find($request->input('presentationVideo.id'));

        $course->category()->associate($cc);
        $course->status()->associate($cs);
        $course->thumbnailImage()->associate($ti);
        $course->coverImage()->associate($ci);
        $course->presentationVideo()->associate($pv);

        $course->save();

        if(!$course){
          return response('Error de creación',500);
        }


        return response(["course"=>$course]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Course $course)
    {

      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $course->delete();
      return request("ok");
    }
}
