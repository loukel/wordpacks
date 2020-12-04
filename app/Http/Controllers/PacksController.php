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
    return view('packs.show', $id);
  }

  public function create() {
    return view('packs.create');
  }
}
