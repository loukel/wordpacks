<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Packs;
use App\Models\Dictionary;

class PacksController extends Controller
{
  public function index() {
    // Lood packs
    $user_id = Auth::id();
    $packs = Packs::where('creator', $user_id)->get(['label']);
    return view('packs.index',[
      'packs' => $packs
    ]);
  }

  public function show($id) {
    $pack = Packs::find($id);

    // Find creator of the pack
    $creator_id = $pack['creator'];
    $creator = User::find($creator_id)['username'];
    // Declare if the viewer created the pack, this should probably change to a laravel roles structure
    $is_creator = Auth::id() === $creator_id;

    // Asign pack label
    $label = $pack['label'];
    // Load words json by allocating words to their definitions
    foreach($pack['words'] as $word) {
      $words[$word] = Dictionary::where('word', strtoupper($word))->get();
    }

    return view('packs.show', [
      'creator' => $creator,
      'is_creator' => $is_creator,
      'label' => $label,
      'words' => $words,
    ]);
  }

  public function create() {
    return view('packs.create');
  }
}
