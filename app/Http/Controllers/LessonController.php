<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Course\Section;
use App\Models\Course\Section\Lesson;
use App\Models\Course\Section\Lesson\LessonStatus;

use Illuminate\Http\Request;

class LessonController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {

    $lessons = Lesson::with('video')
    ->with('status')
    ->get();

    return response(['lessons'=>$lessons]);
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
      'section.id' => 'required|exists:sections,id',
      'video.id' => 'required|exists:videos,id',
      'status.id' => 'required|exists:lesson_statuses,id'
      ])->validate();

      $lesson = new Lesson([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'order' => $request->input('order')
      ]);

      $s = Section::find($request->input('section.id'));
      $v = Video::find($request->input('video.id'));
      $ls = LessonStatus::find($request->input('status.id'));

      $lesson->section()->associate($s);
      $lesson->video()->associate($v);
      $lesson->status()->associate($ls);

      $lesson->save();

      if(!$lesson){
        return response('Error de creación',500);
      }

      return response(["lesson"=>$lesson]);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Course\Section\Lesson  $lesson
    * @return \Illuminate\Http\Response
    */
    public function show(Lesson $lesson)
    {
      $lesson->section;
      $lesson->video;
      $lesson->status;

      return response(["lesson"=>$lesson]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Course\Section\Lesson  $lesson
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Lesson $lesson)
    {

      if(!$request->user()->hasAnyRole(['admin','editor','docente'])){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'description' => 'required|max:5000',
        'order' => 'required|integer',
        'section.id' => 'required|exists:sections,id',
        'video.id' => 'required|exists:videos,id',
        'status.id' => 'required|exists:lesson_statuses,id'
        ])->validate();


        $lesson->name = $request->input('name');
        $lesson->description = $request->input('description');
        $lesson->order = $request->input('order');

        $s = Section::find($request->input('section.id'));
        $v = Video::find($request->input('video.id'));
        $ls = LessonStatus::find($request->input('status.id'));

        $lesson->section()->associate($s);
        $lesson->video()->associate($v);
        $lesson->status()->associate($ls);

        $lesson->save();

        if(!$lesson){
          return response('Error de creación',500);
        }

        return response(["lesson"=>$lesson]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Course\Section\Lesson  $lesson
    * @return \Illuminate\Http\Response
    */
    public function destroy(Lesson $lesson)
    {
      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $lesson->delete();
      return request("ok");
    }
  }
