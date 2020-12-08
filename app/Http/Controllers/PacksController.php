<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use DB;

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

  public function show($pack_id) {
    $pack = Packs::find($pack_id);

    // Find creator of the pack
    $creator_id = $pack['creator'];
    $creator = User::find($creator_id)['username'];
    // Declare if the viewer created the pack, this should probably change to a laravel roles structure
    $is_creator = Auth::id() === $creator_id;

    // Asign pack label
    $label = $pack['label'];
    // Load words json by allocating words to their definitions

    $words = array();
    $words = $pack['words'];

    return view('packs.show', [
      'pack_id' => $pack_id,
      'creator' => $creator,
      'is_creator' => $is_creator,
      'label' => $label,
      'words' => $words,
    ]);
  }

  public function create() {
    return view('packs.create');
  }

  public function add($pack_id, $word) {
    // Find the words senses in the dictionary
    $word_senses = Dictionary::where('word', strtoupper($word))->get(['pos', 'definitions']);

    // Return rogue value if the word is not defined
    if (empty($word_senses)) {
      return -1;

    } else {
      // Create json for the word
      $word_info = json_encode(array('word' => $word, 'senses' => $word_senses));

    }

    // Append the new word to the pack
    try {
      DB::collection('packs')
      ->where('_id', $pack_id)
      ->push('words', json_decode($word_info, true), true);
      // Return to client to dynamically display
      return $word_info;

    }
    catch (\Throwable $th) {
      // If error return rogue value to show it wasn't successful
      return -1;

    }
  }

  public function delete($id, $word) {
    return redirect(`/$id`);
  }

  public function destroy($id) {
    return route('packs.index');
  }
}
