<?php

namespace App\Http\Controllers;

use App\Models\Person\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */


  public function __construct(){
    $this->middleware('auth:api');
  }

  public function index()
  {

    $students = Student::all();

    $students->map(function($students){
      $student->user();
      $student->image();

      return $student;
    });

    return response(['students'=>$students]);
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
      'name' => 'required|unique:courses|max:255',
      'surname' => 'required|unique:courses|max:255',
      'image.id' => 'required|exists:images,id',
      'user.id' => 'required|exists:user,id'
      ])->validate();

      $student = new Student([
        'name' => $request->input('name'),
        'surname' => $request->input('surname'),
      ]);

      $i = Image::find($request->input('image.id'));
      $u = User::find($request->input('user.id'));

      $student->image()->associate($i);
      $student->user()->associate($u);

      $student->save();

      if(!$student){
        return response('Error de creación',500);
      }

      return response(["student"=>$student]);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Person\Student  $student
    * @return \Illuminate\Http\Response
    */
    public function show(Student $student)
    {
      $student->user();
      $student->image();

      return response(['student'=>$student]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Person\Student  $student
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Student $student)
    {


      $validator = Validator::make($request->all(), [
        'name' => 'required|unique:courses|max:255',
        'surname' => 'required|unique:courses|max:255',
        'image.id' => 'required|exists:images,id',
        'user.id' => 'required|exists:user,id'
        ])->validate();

        if(!$request->user()->hasAnyRole(['admin','editor'])){
          if($request->user()->id != $request->input('user.id')){
            return response('Unauthorized',401);
          }
        }


        $student->name = $request->input('name');
        $student->surname = $request->input('surname');

        $i = Image::find($request->input('image.id'));
        $u = User::find($request->input('user.id'));

        $student->image()->associate($i);
        $student->user()->associate($u);

        $student->save();

        if(!$student){
          return response('Error de creación',500);
        }

        return response(["student"=>$student]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Person\Student  $student
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request,Student $student)
    {

      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $student->delete();
      return request('ok');
    }
  }
