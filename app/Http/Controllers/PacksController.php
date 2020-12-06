<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

use App\Models\Packs;
class PacksController extends Controller
{
  public function index() {
    // Lood packs
    $id = Auth::id();
    $packs = Packs::where('creator', $id)->get(['label']);
    return view('packs.index',[
      'packs' => $packs
    ]);
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
