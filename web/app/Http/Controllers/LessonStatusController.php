<?php

namespace App\Http\Controllers;

use App\Models\Course\Section\Lesson\LessonStatus;
use Illuminate\Http\Request;

class LessonStatusController extends Controller
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

      $lessonStatuses = LessonStatus::all();

      return response(['lesson_statuses'=>$lessonStatuses]);
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

        $lessonStatus = LessonStatus::create([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        if(!$lessonStatus){
          return response('Error de creación',500);
        }

        return response(["lesson_student_status"=>$lessonStatus]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course\Section\Lesson\LessonStatus  $lessonStatus
     * @return \Illuminate\Http\Response
     */
    public function show(LessonStatus $lessonStatus)
    {
        return response(["lesson_status"=>$lessonStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course\Section\Lesson\LessonStatus  $lessonStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LessonStatus $lessonStatus)
    {

      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => [
          'required',
          'max:255',
          Rule::unique('lesson_statuses')->ignore($lessonStatus)
        ],
        'description' => 'required|max:255',
        'order' => 'required|integer',
        'default' => 'required|boolean',
        'active' => 'required|boolean'
        ])->validate();

        $lessonStatus = new LessonStatus([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        $lessonStatus->save();

        if(!$lessonStatus){
          return response('Error de creación',500);
        }

        return response(["lesson_status"=>$lessonStatus]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course\Section\Lesson\LessonStatus  $lessonStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(LessonStatus $lessonStatus)
    {
      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $lessonStatus->delete();

      return request("ok");
    }
}
