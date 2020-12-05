<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Controllers\Controller;

class PacksController extends Controller
{
  public function index() {
    return view('packs.index');
  }

  public function show($id) {
    // Load pack json
    return view('packs.show', [
      'id' => $id
    ]);
  }

  public function create() {
    return view('packs.create');
  }
}
