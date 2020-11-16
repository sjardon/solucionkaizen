<?php

namespace App\Http\Controllers;

use App\Models\Course\Section\SectionStatus;
use Illuminate\Http\Request;

class SectionStatusController extends Controller
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

      $sectionStatuses = SectionStatus::all();

      return response(['section_statuses'=>$sectionStatuses]);
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
        'name' => 'required||unique:section_statuses|max:255',
        'description' => 'required|max:255',
        'order' => 'required|integer',
        'default' => 'required|boolean',
        'active' => 'required|boolean'
        ])->validate();

        $sectionStatus = SectionStatus::create([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        if(!$sectionStatus){
          return response('Error de creación',500);
        }

        return response(["section_status"=>$sectionStatus]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course\Section\SectionStatus  $sectionStatus
     * @return \Illuminate\Http\Response
     */
    public function show(SectionStatus $sectionStatus)
    {
      return response(["section_status"=>$sectionStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course\Section\SectionStatus  $sectionStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SectionStatus $sectionStatus)
    {

      if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => [
          'required',
          'max:255',
          Rule::unique('section_statuses')->ignore($sectionStatus)
        ],
        'description' => 'required|max:255',
        'order' => 'required|integer',
        'default' => 'required|boolean',
        'active' => 'required|boolean'
        ])->validate();

        $sectionStatus = new SectionStatus([
          'name' => $request->name,
          'description' => $request->description,
          'order' => $request->order,
          'default' => $request->default,
          'active' => $request->active
        ]);

        $sectionStatus->save();

        if(!$sectionStatus){
          return response('Error de creación',500);
        }

        return response(["section_status"=>$sectionStatus]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course\Section\SectionStatus  $sectionStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(SectionStatus $sectionStatus)
    {

      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $sectionStatus->delete();

      return request("ok");

    }
}
