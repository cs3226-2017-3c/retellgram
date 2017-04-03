<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Image;
use App\Caption;
use App\Hashtag;
use App\CharacterNewLike;

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
      $top_char = CharacterNewLike::orderBy('created_at','desc')->first();
      $top_char->character;
      return $top_char;
      return view('home', ['result' => $captions, 'hashtags' => $hashtags, 'top_char', $top_char]);
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
