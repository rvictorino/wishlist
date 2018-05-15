<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller {


  public function list() {
    return response()->json(User::all());
  }


  public function get($id) {
    $user = User::where('id', $id)->first();
    if (!$user) {
      return response()->json(['success' => false], 400);
    }
    return response()->json($user);
  }


  public function update(Request $request) {
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required',
      'confirmation' => 'required|same:password',
    ]);
    $user = User::where('email', $this->request->input('email'))->first();
    if (!$user) {
        return response()->json(['success' => false], 400);
    }
    $user->password = Hash::make($request->get('password'));
    $user->save();
    return response()->json($user, 200);
  }

}

 ?>
