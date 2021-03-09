<?php

namespace App\Http\Controllers;

use App\Models\CourseStudent\CourseStudentStatus;
use Illuminate\Http\Request;

class CourseStudentStatusController extends Controller
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

    $courseStudentStatuses = CourseStudentStatus::all();

    return response(['course_student_statuses'=>$courseStudentStatuses]);
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
      'name' => 'required||unique:course_student_statuses|max:255',
      'description' => 'required|max:255',
      'order' => 'required|integer',
      'default' => 'required|boolean',
      'active' => 'required|boolean'
      ])->validate();

      $courseStudentStatus = CourseStudentStatus::create([
        'name' => $request->name,
        'description' => $request->description,
        'order' => $request->order,
        'default' => $request->default,
        'active' => $request->active
      ]);

      if(!$courseStudentStatus){
        return response('Error de creación',500);
      }

      return response(["course_student_status"=>$courseStudentStatus]);

  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Models\CourseStudent\CourseStudentStatus  $courseStudentStatus
  * @return \Illuminate\Http\Response
  */
  public function show(CourseStudentStatus $courseStudentStatus)
  {
      return response(["course_student_status"=>$courseStudentStatus]);
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Models\CourseStudent\CourseStudentStatus  $courseStudentStatus
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, CourseStudentStatus $courseStudentStatus)
  {

          if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
            return response('Unauthorized',401);
          }

          $validator = Validator::make($request->all(), [
            'name' => [
              'required',
              'max:255',
              Rule::unique('course_student_statuses')->ignore($courseStudentStatus)
            ],
            'description' => 'required|max:255',
            'order' => 'required|integer',
            'default' => 'required|boolean',
            'active' => 'required|boolean'
            ])->validate();

            $courseStudentStatus = new CourseStudentStatus([
              'name' => $request->name,
              'description' => $request->description,
              'order' => $request->order,
              'default' => $request->default,
              'active' => $request->active
            ]);

            $courseStudentStatus->save();

            if(!$courseStudentStatus){
              return response('Error de creación',500);
            }

            return response(["course_student_status"=>$courseStudentStatus]);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Models\CourseStudent\CourseStudentStatus  $courseStudentStatus
  * @return \Illuminate\Http\Response
  */
  public function destroy(CourseStudentStatus $courseStudentStatus)
  {

            if(!$request->user()->hasAnyRole(['admin','editor'])){
              return response('Unauthorized',401);
            }

            $courseStudentStatus->delete();

            return request("ok");

  }
}
