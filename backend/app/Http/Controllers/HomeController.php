<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Image;
use App\Caption;
use App\Hashtag;
use App\CharacterNewLike;
use App\Character;

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

      $lastest_like_time = CharacterNewLike::orderBy('created_at','desc')->first()->created_at;
      $latest_likes = CharacterNewLike::where('created_at', $lastest_like_time)->get();

      $factions_likes = ['red':0,'yellow':0,'green':0,'blue':0];

      foreach ( $latest_likes as $like ){
        $factions_likes[Character::get($like->character_id)->faction]+= (int)$like->new_like;
      }

      $rule_faction = array_keys($factions_likes, max($factions_likes));

      return view('home', ['result' => $captions, 'hashtags' => $hashtags, 'rule_faction' => $rule_faction]);
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
