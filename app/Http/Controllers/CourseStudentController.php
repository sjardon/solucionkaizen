<?php

namespace App\Http\Controllers;

use App\Models\CourseStudent;
use Illuminate\Http\Request;

class CourseStudentController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {

    //Después va a haber que especificar si
    //  para un curso trae todos sus alumnos
    //  o para un alumno trae todos sus cursos

    $coursesStudents = CourseStudent::with([
      'course',
      'student',
      'status',
      'sections'
      ])->get();

      return response(['courses_students'=>$coursesStudents]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {

      // if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
      //   return response('Unauthorized',401);
      // }

      $validator = Validator::make($request->all(), [
        'course.id' => 'required|exists:courses,id',
        'student.id' => 'required|exists:students,id',
        'status.id' => 'required|exists:course_student_statuses,id'
        ])->validate();

        $courseStudent = new CourseStudent();


        $courseStudent->course()->associate(
          Course::find($request->input('course.id'))
        );

        $courseStudent->student()->associate(
          Student::find($request->input('student.id'))
        );

        $courseStudent->status()->associate(
          CourseStudentStatus::find($request->input('status.id'))
        );

        $courseStudent->save();

        if(!$courseStudent){
          return response('Error de creación',500);
        }

        return response(["course_student"=>$courseStudent]);
      }

      /**
      * Display the specified resource.
      *
      * @param  \App\Models\CourseStudent  $courseStudent
      * @return \Illuminate\Http\Response
      */
      public function show(CourseStudent $courseStudent)
      {
        $courseStudent->course;
        $courseStudent->student;
        $courseStudent->status;

        return response(["course_student"=>$courseStudent]);
      }

      /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \App\Models\CourseStudent  $courseStudent
      * @return \Illuminate\Http\Response
      */
      public function update(Request $request, CourseStudent $courseStudent)
      {

        // Puede hacer un update del curso o el estudiante? No.
        $validator = Validator::make($request->all(), [
          'status.id' => 'required|exists:course_student_statuses,id'
          ])->validate();


          $courseStudent->status()->associate(
            CourseStudentStatus::find($request->input('status.id'))
          );

          $courseStudent->save();

          if(!$courseStudent){
            return response('Error de creación',500);
          }

          return response(["course_student"=>$courseStudent]);

      }

      /**
      * Remove the specified resource from storage.
      *
      * @param  \App\Models\CourseStudent  $courseStudent
      * @return \Illuminate\Http\Response
      */
      public function destroy(CourseStudent $courseStudent)
      {

        if(!$request->user()->hasAnyRole(['admin','editor'])){
          return response('Unauthorized',401);
        }

        $courseStudent->delete();
        return request("ok");
      }
    }
