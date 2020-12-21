<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

use Illuminate\Http\Request;

use Auth;

use DB;

use App\Models\User;
use App\Models\Packs;
use App\Models\Dictionary;

class PacksController extends Controller {
  public function __construct() {
      $this->middleware('auth')->except(['index','show']);
  }

  public function index() {
    // Get public packs
    $public_packs = Packs::latest()->take(6)->get();

    $packs = array();
    if (Auth::check()) {
      // Get user's packs
      $packs = Packs::where('user_id', Auth::id())->get();

      // Meta Tags
      $username = Auth::user()->username;
      $pack_count = count($packs);
      SEOMeta::setTitle("$username ($pack_count)");
    }

    return view('packs.index',[
      'packs' => $packs,
      'public_packs' => $public_packs,
    ]);
  }

  public function show($pack_id) {
    $pack = Packs::find($pack_id);
    if (!empty($pack)) {
      // Meta tags
      SEOMeta::setTitle($pack->label);
      OpenGraph::setTitle($pack->label);
      JsonLd::setTitle($pack->label);

      if ($pack->words) {
        foreach($pack->words as $word) {
          $words[] = $word['word'];
        }

        SEOMeta::setDescription(implode(",", $words));
        OpenGraph::setDescription(implode(",", $words));
        JsonLd::setDescription(implode(",", $words));
      }

      return view('packs.show', [
        'pack' => $pack,
      ]);
    } else {
      abort(404);
    }
  }

  public function create() {
    $pack = new Packs;
    $pack = Packs::create(array(
      'user_id' => Auth::id(),
      'label' => 'New pack',
      'words' => Array(),
    ));
    return redirect(route('packs.show', $pack->id));
  }

  public function add($pack_id) {
    $pack_id = sanitize_string($pack_id);
    $word = sanitize_string(request('word'));

    if (isset($_POST['define'])) {
      // Find the words senses in the dictionary
      $word_senses = Dictionary::where('word', strtoupper($word))->get(['pos', 'definitions']);

      // Return rogue value if the word is not defined
      if ($word_senses == "[]") {
        return redirect(route('packs.show', $pack_id))->with('error', 'Word not found');

      } else {
        // Create json for the word
        $word_info = json_encode(array('word' => $word, 'senses' => $word_senses));

      }
    } else if (isset($_POST['custom'])) {
      $word_info = json_encode(array('word' => $word, 'notes' => ''));
    }

    // Append the new word to the pack
    try {
      DB::collection('packs')
      ->where('_id', $pack_id)
      ->where('user_id', Auth::id())
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
        return DB::collection('packs')->where('_id', $pack_id)->where('user_id', Auth::id())->update(['label' => $label]);
      } catch (\Throwable $th) {
        return 'error: '.$th;
      }
    }
  }

  public function edit($pack_id, $word) {
    if (isset($_POST['note'])) {
      $note = sanitize_string($_POST['note']);
      try {
        return DB::collection('packs')->where('_id', $pack_id)->where('user_id', Auth::id())->where('words.word',$word)->update(['words.$.notes' => $note]);
      } catch (\Throwable $th) {
        return 'error: '.$th;
      }
    }
  }

  public function delete($pack_id, $word) {
    DB::collection('packs')->where('_id', $pack_id)->where('user_id', Auth::id())->pull('words', ['word' => sanitize_string($word)], true);
    return redirect(route('packs.show', $pack_id));
  }

  public function destroy($pack_id) {
    $pack = Packs::where('_id', sanitize_string($pack_id))->where('user_id', Auth::id());
    try {
      $pack->delete();
    } catch (\Throwable $th) {
      return redirect(route('packs.index'))->with('error','Didn\'t delete pack: '.$pack_id);
    }
    return redirect(route('packs.index'));
  }
}

function sanitize_string($var) {
  $var = strip_tags($var);
  $var = htmlentities($var);
  return stripslashes($var);
}
