<?php

namespace App\Http\Controllers;

use App\Wish;
use Illuminate\Http\Request;

class WishController extends Controller {


  public function list() {
    return response()->json(Wish::all());
  }


  public function get($id) {
    $wish = Wish::where('id', $id)->first();
    if (!$wish) {
      return response()->json(['success' => false], 400);
    }
    return response()->json($wish);
  }

  public function create(Request $request) {
    $this->validate($request, [
      'title' => 'required|unique:wishes',
      'url' => 'nullable|url'
    ]);
    $wish = Wish::create($request->all());
    return response()->json($wish, 201);
  }

  public function update($id, Request $request) {
    $this->validate($request, [
      'title' => 'sometimes|required|unique:wishes',
      'url' => 'nullable|url'
    ]);
    $wish = Wish::findOrFail($id);
    $wish->update($request->all());
    return response()->json($wish, 200);
  }

  public function delete($id) {
    Wish::findOrFail($id)->delete();
    return response()->json(['success' => true], 200);
  }

}

 ?>
