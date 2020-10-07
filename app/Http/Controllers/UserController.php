<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\User\Role;
use App\Models\Person\Student;


class UserController extends Controller
{

  public function __construct(){
    $this->middleware('auth:api', ['only' => ['index','update','destroy','show']]);
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */

  public function index(Request $request)
  {
    //Listado de usuarios. Se pueden agregar filtros.
    $users = User::all();

    $users->map(function($user){

      $user->roles;
      $user->person;

      return $user;

    });

    return response(['users'=>$users]);
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //Registro de usuario.

    $validator = Validator::make($request->all(), [
      'personalName' => 'required',
      'personalSurname' => 'required',
      'name' => 'required|unique:users',
      'email' => 'required|unique:users|email',
      'password' => 'required'
      ])->validate();

      $request["password"] = Hash::make($request["password"]);


      $user = User::create(request(["name","email","password"]));

      if(!$user){
        return response('Error de creación',500);
      }

      $student = new Student([
        'name'=>$request->input('personalName'),
        'surname'=>$request->input('personalSurname')
      ]);

      $user->person()->save($student);

      $user->roles()->attach(Role::where('name', 'estudiante')->first());

      $user->person->get();
      $user->roles;

      return response(["user"=>$user]);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function show(User $user)
    {
      
      $user->person->get();
      $user->roles;
      return response(["user"=>$user]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, User $user)
    {
      //Actualiza un usuario.
      //Van a poder actualizar el email o la contraseña, pero no todo el usuario

      if($user->id != $request->user()->id && !$request->user()->hasRole('admin')){
        return response('Unauthorized',401);
      }

      $validator = Validator::make($request->all(), [
        'email' => [
          'required',
          'max:255',
          Rule::unique('users')->ignore($user)
        ]
        ])->validate();

      $user->email = $request->email;

      $user->save();

      return response(["user"=>$user]);

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, User $user)
    {
      //Borra un usuario.

      if(!$request->user()->hasRole('admin')){
        return response('Unauthorized',401);
      }

      $user->delete();
      return request("ok");


    }
  }
