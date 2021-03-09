<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Course\Section;
use App\Models\Course\Section\SectionStatus;
use Illuminate\Http\Request;

class SectionController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $sections = Section::with('lessons')
    ->with('status')
    ->get();

    return response(['sections'=>$sections]);
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
      'name' => 'required|max:255',
      'description' => 'required|max:5000',
      'order' => 'required|integer',
      'course.id' => 'required|exists:courses,id',
      'status.id' => 'required|exists:section_statuses,id'
      ])->validate();

      $section = new Section([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'order' => $request->input('order')
      ]);

      $c = Course::find($request->input('course.id'));
      $ss = SectionStatus::find($request->input('status.id'));

      $section->course()->associate($c);
      $section->status()->associate($ss);

      $section->save();

      if(!$section){
        return response('Error de creación',500);
      }

      return response(["section"=>$section]);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Course\Section  $section
    * @return \Illuminate\Http\Response
    */
    public function show(Section $section)
    {
      $section->course;
      $section->lessons;
      $section->status;

      return response(["section"=>$section]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Course\Section  $section
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Section $section)
    {
      if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'description' => 'required|max:5000',
        'order' => 'required|integer',
        'course.id' => 'required|exists:courses,id',
        'status.id' => 'required|exists:section_statuses,id'
        ])->validate();

        $section->name = $request->input('name');
        $section->description = $request->input('description');
        $section->order = $request->input('order');

        $c = Course::find($request->input('course.id'));
        $ss = SectionStatus::find($request->input('status.id'));

        $section->course()->associate($c);
        $section->status()->associate($ss);

        $section->save();

        if(!$section){
          return response('Error de creación',500);
        }

        return response(["section"=>$section]);
      }

      /**
      * Remove the specified resource from storage.
      *
      * @param  \App\Models\Course\Section  $section
      * @return \Illuminate\Http\Response
      */
      public function destroy(Section $section)
      {

        if(!$request->user()->hasAnyRole(['admin','editor'])){
          return response('Unauthorized',401);
        }

        $section->delete();
        return request("ok");
      }
    }
