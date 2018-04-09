<?php

namespace App\Http\Controllers;

use App\Wish;
use Illuminate\Http\Request;

class WishController extends Controller {


  public function list() {
    return response()->json(Wish::all());
  }


  public function get($id) {
    return response()->json(Wish::all());
  }

  public function create(Request $request) {
    $wish = Wish::create($request->all());
    return response()->json($wish, 201);
  }

  public function update($id, Request $request) {
    $wish = Wish::findOrFail($id);
    $wish->update($request->all());
    return response()->json($wish, 200);
  }

  public function delete($id) {
    Wish::findOrFail($id)->delete();
    return response('Deleted Successfully', 200);
  }

}

 ?>
