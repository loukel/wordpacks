<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Models\User;
use App\Models\Packs;
use App\Models\Dictionary;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $packs = Packs::all()->take(6);
      foreach($packs as &$pack) {
        $pack['username'] = User::find($pack->creator)['username'];
      }
      return view('home', ['packs' => $packs]);
    }
}
