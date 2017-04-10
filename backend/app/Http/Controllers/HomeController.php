<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Image;
use App\Caption;
use App\Hashtag;
use App\CharacterNewLike;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Character;
use DB;
use Cookie;

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
      if ( strpos($request->url(), 'home') !== false  ) {
        $captions = Caption::orderBy('likes', 'desc')->get();
      } else {
        $captions = Caption::orderBy('created_at', 'desc')->get();
      }
      
      $captions = $captions->keyBy('id');
      foreach ($captions as $c) {
        if ( Image::findOrFail($c->image_id)->reports > 10){
          $captions->forget($c->id);
        }
      }

      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $perPage = 10;
      $currentPageSearchResults = $captions->slice(($currentPage-1) * $perPage, $perPage)->all();

      $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($captions), $perPage);

      if ( strpos($request->url(), 'home') !== false  ) {
        $paginatedSearchResults->setPath('/home');
      } else {
        $paginatedSearchResults->setPath('/');
      }

      foreach ($paginatedSearchResults as $c) {
        $c->image;
        $c->hashtags;
      }

      $champions = array();

      $timestamps = DB::table('character_new_like')->select('created_at')->distinct()->get()->sortByDesc('created_at');
      if ($timestamps->count() >= 5) {
          $timestamps = $timestamps->slice(0,5);
      }

      foreach ($timestamps as $timestamp ) {
        $latest_likes = array();
        $latest_likes = CharacterNewLike::where('created_at', $timestamp->{'created_at'})->get();
        $factions_likes = ['red'=>0,'yellow'=>0,'green'=>0,'blue'=>0];

        foreach ( $latest_likes as $like ){
          $faction = Character::findOrfail((int)$like->character_id)->faction;
          $factions_likes[$faction]+= (int)$like->new_like;
        }

        $rule_factions = array_keys($factions_likes, max($factions_likes));
        array_push($champions, $rule_factions);
      }

      $current_rulers = $champions[0];
      $current_rulers_with_level = array();
      foreach ($current_rulers as $ruler) {
        $level = 0;
        foreach ($champions as $champion){
          if (!in_array($ruler, $champion)){
            break;
          }
          $level+=1;
        }
        $current_rulers_with_level[$ruler] = $level;
      }

      if (!isset($_COOKIE['retellgram_visited'])) {
          setcookie('retellgram_visited', "true",86400 * 30);
          return view('home', ['result' => $paginatedSearchResults, 'hashtags' => $hashtags, 'rule_factions' => $current_rulers_with_level, 'visited' => false]);
      }

      return view('home', ['result' => $paginatedSearchResults, 'hashtags' => $hashtags, 'rule_factions' => $current_rulers_with_level,'visited' => true]);
    }

    public function latest()
    {
        $hashtags = Hashtag::withCount('captions')->get()->sortByDesc('captions_count')->slice(0, 10);
        $captions = Caption::orderBy('created_at', 'desc')->get();
        $captions = $captions->keyBy('id');
        foreach ($captions as $c) {
          if ( Image::findOrFail($c->image_id)->reports > 10){
            $captions->forget($c->id);
          }
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageSearchResults = $captions->slice(($currentPage-1) * $perPage, $perPage)->all();

        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($captions), $perPage);

     
        foreach ($captions as $c) {
          $c->image;
          $c->hashtags;
        }
        $paginatedSearchResults->setPath('/newest');

        return view('home', ['result' => $paginatedSearchResults, 'hashtags' => $hashtags]);
    }
}
