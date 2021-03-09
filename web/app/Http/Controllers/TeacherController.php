<?php

namespace App\Http\Controllers;

use App\Models\Person\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $teachers = Teacher::with('user')
      ->with('image')
      ->get();


      return response(['teachers'=>$teachers]);
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
        'user.id' => 'required|exists:user,id',
        'cv' => 'max:40000',
        'biography' => 'max:40000',
        'webUrl' => 'max:150'
        ])->validate();

        $teacher = new Teacher([
          'name' => $request->input('name'),
          'surname' => $request->input('surname'),
          'cv' => $request->input('cv'),
          'biography' => $request->input('biography'),
          'webUrl' => $request->input('webUrl')
        ]);

        $i = Image::find($request->input('image.id'));
        $u = User::find($request->input('user.id'));

        $teacher->image()->associate($i);
        $teacher->user()->associate($u);

        $teacher->save();

        if(!$teacher){
          return response('Error de creación',500);
        }

        return response(["teacher"=>$teacher]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
      $teacher->user;
      $teacher->image;

      return response(['teacher'=>$teacher]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {

      $validator = Validator::make($request->all(), [
        'name' => 'required|unique:courses|max:255',
        'surname' => 'required|unique:courses|max:255',
        'image.id' => 'required|exists:images,id',
        'user.id' => 'required|exists:user,id',
        'cv' => 'max:40000',
        'biography' => 'max:40000',
        'webUrl' => 'max:150'
        ])->validate();


        if(!$request->user()->hasAnyRole(['admin','editor'])){
          if($request->user()->id != $request->input('user.id')){
            return response('Unauthorized',401);
          }
        }

        $teacher = new Teacher([
          'name' => $request->input('name'),
          'surname' => $request->input('surname'),
          'cv' => $request->input('cv'),
          'biography' => $request->input('biography'),
          'webUrl' => $request->input('webUrl')
        ]);


        $teacher->name = $request->input('name');
        $teacher->surname = $request->input('surname');
        $teacher->cv = $request->input('cv');
        $teacher->biography = $request->input('biography');
        $teacher->webUrl = $request->input('webUrl');

        $i = Image::find($request->input('image.id'));
        $u = User::find($request->input('user.id'));

        $teacher->image()->associate($i);
        $teacher->user()->associate($u);

        $teacher->save();

        if(!$teacher){
          return response('Error de creación',500);
        }

        return response(["teacher"=>$teacher]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {

      if(!$request->user()->hasAnyRole(['admin','editor'])){
        return response('Unauthorized',401);
      }

      $student->delete();
      return request('ok');
    }
}
