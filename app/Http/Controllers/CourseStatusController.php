<?php

namespace App\Http\Controllers;

use App\Models\Course\CourseStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CourseStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $courseStatuses = CourseStatus::all();

      return response(['course_statuses'=>$courseStatuses]);
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

        $courseStatus = CourseStatus::create([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        if(!$courseStatus){
          return response('Error de creación',500);
        }

        return response(["course_status"=>$courseStatus]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course\CourseStatus  $courseStatus
     * @return \Illuminate\Http\Response
     */
    public function show(CourseStatus $courseStatus)
    {
      return response(["course_status"=>$courseStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course\CourseStatus  $courseStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseStatus $courseStatus)
    {

      if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => [
          'required',
          'max:255',
          Rule::unique('course_statuses')->ignore($courseStatus)
        ],
        'description' => 'required|max:255',
        'order' => 'required|integer',
        'default' => 'required|boolean',
        'active' => 'required|boolean'
        ])->validate();

        $courseStatus = new CourseStatus([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        $courseStatus->save();

        if(!$courseStatus){
          return response('Error de creación',500);
        }

        return response(["course_status"=>$courseStatus]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course\CourseStatus  $courseStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseStatus $courseStatus)
    {

        if(!$request->user()->hasAnyRole(['admin','editor'])){
          return response('Unauthorized',401);
        }

        $courseStatus->delete();

        return request("ok");

    }
}
