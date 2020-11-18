<?php

namespace App\Http\Controllers;

use App\Models\CourseStudent\SectionStudent\SectionStudentStatus;
use Illuminate\Http\Request;

class SectionStudentStatusController extends Controller
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

      $sectionStudentStatuses = SectionStudentStatus::all();

      return response(['section_student_statuses'=>$sectionStudentStatuses]);
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
            'name' => 'required||unique:section_student_statuses|max:255',
            'description' => 'required|max:255',
            'order' => 'required|integer',
            'default' => 'required|boolean',
            'active' => 'required|boolean'
            ])->validate();

            $sectionStudentStatus = SectionStudentStatus::create([
              'name' => $request->name,
              'description' => $request->description,
              'order' => $request->order,
              'default' => $request->default,
              'active' => $request->active
            ]);

            if(!$sectionStudentStatus){
              return response('Error de creación',500);
            }

            return response(["section_student_status"=>$sectionStudentStatus]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseStudent\SectionStudent\SectionStudentStatus  $sectionStudentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(SectionStudentStatus $sectionStudentStatus)
    {

        return response(["section_student_status"=>$sectionStudentStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseStudent\SectionStudent\SectionStudentStatus  $sectionStudentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SectionStudentStatus $sectionStudentStatus)
    {

      if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => [
          'required',
          'max:255',
          Rule::unique('section_student_statuses')->ignore($sectionStudentStatus)
        ],
        'description' => 'required|max:255',
        'order' => 'required|integer',
        'default' => 'required|boolean',
        'active' => 'required|boolean'
        ])->validate();

        $sectionStudentStatus = new SectionStudentStatus([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        $sectionStudentStatus->save();

        if(!$sectionStudentStatus){
          return response('Error de creación',500);
        }

        return response(["section_student_status"=>$sectionStudentStatus]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseStudent\SectionStudent\SectionStudentStatus  $sectionStudentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(SectionStudentStatus $sectionStudentStatus)
    {

      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $sectionStudentStatus->delete();

      return request("ok");

    }
}
