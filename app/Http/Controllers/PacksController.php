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

  public function add() {
    // Define varaibles
    if (isset($_POST['define'])) {
      $mode = 'define';
    } elseif (isset($_POST['custom'])) {
      $mode = 'custom';
    }
    $word = SanitizeString(request('word'));
    $pack_id = SanitizeString(request('pack_id'));

    if ($mode == "define") {
      // Find the words senses in the dictionary
      $word_senses = Dictionary::where('word', strtoupper($word))->get(['pos', 'definitions']);

      // Return rogue value if the word is not defined
      if ($word_senses == "[]") {
        return redirect(route('packs.show', $pack_id))->with('error', 'Click to change');

      } else {
        // Create json for the word
        $word_info = json_encode(array('word' => $word, 'senses' => $word_senses));

      }
    } else {
      $word_info = json_encode(array('word' => $word, 'notes' => ''));
    }

    // Append the new word to the pack
    try {
      DB::collection('packs')
      ->where('_id', $pack_id)
      ->push('words', json_decode($word_info, true), true);

    }
    catch (\Throwable $th) {
      return redirect(route('packs.show', $pack_id))->with('error', 'Word was not stored');

    }
    return redirect(route('packs.show', $pack_id));
  }

  public function label() {

  }

  public function edit($pack_id, $word) {
    if (isset($_POST['note'])) {
      $note = SanitizeString($_POST['note']);
      try {
        return DB::collection('packs')->where('_id', $pack_id)->where('words.word',$word)->update(['words.$.notes' => $note]);
      } catch (\Throwable $th) {
        return 'error: '.$th;
      }
    }
  }

  public function delete($pack_id, $word) {
    DB::collection('packs')->where('_id', $pack_id)->pull('words', ['word' => SanitizeString($word)], true);
    return redirect(route('packs.show', $pack_id));
  }

  public function destroy($id) {
    return route('packs.index');
  }
}

function SanitizeString($var)
{
  $var = strip_tags($var);
  $var = htmlentities($var);
  return stripslashes($var);
}
