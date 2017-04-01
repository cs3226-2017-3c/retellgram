<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
      $captions = Caption::all()->sortByDesc('likes');
      foreach ($captions as $c) {
        $c->image;
        $c->hashtags;
      }

      return view('home', ['result' => $captions, 'hashtags' => $hashtags]);
    }

    public function latest()
    {
        $hashtags = Hashtag::withCount('captions')->get()->sortByDesc('captions_count')->slice(0, 10);
        $captions = Caption::all()->sortByDesc('created_at');
        foreach ($captions as $c) {
          $c->image;
          $c->hashtags;
        }

        return view('home', ['result' => $captions, 'hashtags' => $hashtags]);
    }
}
