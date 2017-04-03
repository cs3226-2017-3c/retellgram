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
    public function home(Request $request)
    {
      $hashtags = Hashtag::withCount('captions')->get()->sortByDesc('captions_count')->slice(0, 10);
      $captions = Caption::orderBy('likes', 'desc')->simplePaginate(20);
      foreach ($captions as $c) {
        $c->image;
        $c->hashtags;
      }

      $lastest_like_time = CharacterNewLike::orderBy('created_at','desc')->first()->created_at;
      $latest_likes = CharacterNewLike::where('created_at', $lastest_like_time)->get();

      $factions_likes = ['red'=>0,'yellow'=>0,'green'=>0,'blue'=>0];

      foreach ( $latest_likes as $like ){
        $faction = Character::findOrfail((int)$like->character_id)->faction;
        $factions_likes[$faction]+= (int)$like->new_like;
      }

      $rule_factions = array_keys($factions_likes, max($factions_likes));

      if (!$request->session()->has('retellgram_visited')) {
          $request->session()->put('retellgram_visited', 'true');
          return view('home', ['result' => $captions, 'hashtags' => $hashtags, 'rule_factions' => $rule_factions, 'visited' => false]);
      }

      return view('home', ['result' => $captions, 'hashtags' => $hashtags, 'rule_factions' => $rule_factions,'visited' => true]);
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
