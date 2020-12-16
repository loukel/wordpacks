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
  public function __construct()
  {
    // $this->middleware('auth');
  }

  public function index() {
    // Lood packs
    $user_id = Auth::id();
    $packs = Packs::where('creator', $user_id)->get(['label']);

    $public_packs = Packs::all()->sortByDesc('created_at')->take(6);
    foreach($public_packs as &$pack) {
      $pack['username'] = User::find($pack->creator)['username'];
    }

    return view('packs.index',[
      'packs' => $packs,
      'public_packs' => $public_packs,
      'logged_in' => Auth::check(),
    ]);
  }

  public function show($pack_id) {
    $pack = Packs::find($pack_id);
    if (!empty($pack)) {
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
    } else {
      abort(404);
    }
  }

  public function create() {
    $user_id = Auth::id();
    $pack = new Packs;
    $pack = Packs::create(array(
      'creator' => $user_id,
      'label' => 'New pack',
      'words' => Array(),
    ));
    return redirect(route('packs.show', $pack->id));
  }

  public function add() {
    // Define varaibles
    if (isset($_POST['define'])) {
      $mode = 'define';
    } elseif (isset($_POST['custom'])) {
      $mode = 'custom';
    }
    $word = sanitize_string(request('word'));
    $pack_id = sanitize_string(request('pack_id'));

    if ($mode == "define") {
      // Find the words senses in the dictionary
      $word_senses = Dictionary::where('word', strtoupper($word))->get(['pos', 'definitions']);

      // Return rogue value if the word is not defined
      if ($word_senses == "[]") {
        return redirect(route('packs.show', $pack_id))->with('error', 'Word not found');

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
      ->where('creator', Auth::id())
      ->push('words', json_decode($word_info, true), true);

    }
    catch (\Throwable $th) {
      return redirect(route('packs.show', $pack_id))->with('error', 'Word was not stored');

    }
    return redirect(route('packs.show', $pack_id));
  }

  public function update($pack_id) {
    if (isset($_POST['label'])) {
      $label = sanitize_string($_POST['label']);
      try {
        return DB::collection('packs')->where('_id', $pack_id)->where('creator', Auth::id())->update(['label' => $label]);
      } catch (\Throwable $th) {
        return 'error: '.$th;
      }
    }
  }

  public function edit($pack_id, $word) {
    if (isset($_POST['note'])) {
      $note = sanitize_string($_POST['note']);
      try {
        return DB::collection('packs')->where('_id', $pack_id)->where('creator', Auth::id())->where('words.word',$word)->update(['words.$.notes' => $note]);
      } catch (\Throwable $th) {
        return 'error: '.$th;
      }
    }
  }

  public function delete($pack_id, $word) {
    DB::collection('packs')->where('_id', $pack_id)->where('creator', Auth::id())->pull('words', ['word' => sanitize_string($word)], true);
    return redirect(route('packs.show', $pack_id));
  }

  public function destroy($pack_id) {
    $pack = Packs::where('_id', sanitize_string($pack_id))->where('creator', Auth::id());
    try {
      $pack->delete();
    } catch (\Throwable $th) {
      return redirect(route('packs.index'))->with('error','Didn\'t delete pack: '.$pack_id);
    }
    return redirect(route('packs.index'));
  }
}

function sanitize_string($var)
{
  $var = strip_tags($var);
  $var = htmlentities($var);
  return stripslashes($var);
}
