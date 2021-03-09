<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //Loguea un usuario: Genera el token y lo devuelve.

      $login = $request->validate([
        'email' => 'required | string',
        'password' => 'required | string'
      ]);

      if(!Auth::attempt($login)){
        return response(["message"=>"No login"]);
      }

      $user = Auth::user();

      $accessToken = $user->createToken('authToken')->accessToken;

      $user->person;
      $user->roles;

      // return response([ 'user' => Auth::user(),'access_token' => $accessToken ]);
      return response([ 'user' => $user,'access_token' => $accessToken ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
