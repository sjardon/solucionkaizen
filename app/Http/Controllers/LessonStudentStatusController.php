<?php

namespace App\Http\Controllers;

use App\Models\CourseStudent\SectionStudent\LessonStudent\LessonStudentStatus;
use Illuminate\Http\Request;

class LessonStudentStatusController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:api', ['only' => ['store','update','destroy']]);
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $lessonStudentStatuses = LessonStudentStatus::all();

    return response(['lesson_student_statuses'=>$lessonStudentStatuses]);
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
        'name' => 'required||unique:course_statuses|max:255',
        'description' => 'required|max:255',
        'order' => 'required|integer',
        'default' => 'required|boolean',
        'active' => 'required|boolean'
        ])->validate();

        $lessonStudentStatus = LessonStudentStatus::create([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        if(!$lessonStudentStatus){
          return response('Error de creación',500);
        }

        return response(["lesson_student_status"=>$lessonStudentStatus]);

    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\CourseStudent\SectionStudent\LessonStudent\LessonStudentStatus  $lessonStudentStatus
    * @return \Illuminate\Http\Response
    */
    public function show(LessonStudentStatus $lessonStudentStatus)
    {
      return response(["lesson_student_status"=>$lessonStudentStatus]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\CourseStudent\SectionStudent\LessonStudent\LessonStudentStatus  $lessonStudentStatus
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, LessonStudentStatus $lessonStudentStatus)
    {

      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => [
          'required',
          'max:255',
          Rule::unique('lesson_student_statuses')->ignore($lessonStudentStatus)
        ],
        'description' => 'required|max:255',
        'order' => 'required|integer',
        'default' => 'required|boolean',
        'active' => 'required|boolean'
        ])->validate();

        $lessonStudentStatus = new LessonStudentStatus([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        $lessonStudentStatus->save();

        if(!$lessonStudentStatus){
          return response('Error de creación',500);
        }

        return response(["lesson_student_status"=>$lessonStudentStatus]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\CourseStudent\SectionStudent\LessonStudent\LessonStudentStatus  $lessonStudentStatus
    * @return \Illuminate\Http\Response
    */
    public function destroy(LessonStudentStatus $lessonStudentStatus)
    {
      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $lessonStudentStatus->delete();

      return request("ok");
    }
  }
