<?php

namespace App\Http\Controllers;

use App\Models\Course\CourseCategoryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseCategoryStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $courseCategoryStatuses = CourseCategoryStatus::all();

      return response(['course_category_statuses'=>$courseCategoryStatuses]);
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
        'name' => 'required||unique:course_category_statuses|max:255',
        'description' => 'required|max:255',
        'order' => 'required|integer',
        'default' => 'required|boolean',
        'active' => 'required|boolean'
        ])->validate();

        $courseCategoryStatus = CourseCategoryStatus::create([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        if(!$courseCategoryStatus){
          return response('Error de creación',500);
        }

        return response(["course_category_status"=>$courseCategoryStatus]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course\CourseCategoryStatus  $courseCategoryStatus
     * @return \Illuminate\Http\Response
     */
    public function show(CourseCategoryStatus $courseCategoryStatus)
    {
      return response(["course_category_status"=>$courseCategoryStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course\CourseCategoryStatus  $courseCategoryStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseCategoryStatus $courseCategoryStatus)
    {

      if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => [
          'required',
          'max:255',
          Rule::unique('course_category_statuses')->ignore($courseCategoryStatus)
        ],
        'description' => 'required|max:255',
        'order' => 'required|integer',
        'default' => 'required|boolean',
        'active' => 'required|boolean'
        ])->validate();

        $courseCategoryStatus = new CourseCategoryStatus([
          // 'id' => $request->id,
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        $courseCategoryStatus->save();

        if(!$courseCategoryStatus){
          return response('Error de creación',500);
        }

        return response(["course_category_status"=>$courseCategoryStatus]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course\CourseCategoryStatus  $courseCategoryStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseCategoryStatus $courseCategoryStatus)
    {
      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $courseCategoryStatus->delete();

      return request("ok");

    }
}
