<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Image;
use App\Caption;
use App\Hashtag;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
      $hashtags = Hashtag::withCount('captions')->get()->sortByDesc('captions_count')->slice(0, 10);
      $captions = Caption::orderBy('likes', 'desc')->simplePaginate(20);
      foreach ($captions as $c) {
        $c->image;
        $c->hashtags;
      }
      $top_char = DB::table('character_new_like')->orderBy('created_at','desc')->first();
      return view('home', ['result' => $captions, 'hashtags' => $hashtags, 'char', $top_char]);
    }

    public function latest()
    {
        $hashtags = Hashtag::withCount('captions')->get()->sortByDesc('captions_count')->slice(0, 10);
        $captions = Caption::orderBy('created_at', 'desc')->simplePaginate(20);
        foreach ($captions as $c) {
          $c->image;
          $c->hashtags;
        }

        return view('home', ['result' => $captions, 'hashtags' => $hashtags]);
    }
}
