<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Image;
use App\Caption;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
      $captions = Caption::all()->sortByDesc('likes');
      foreach ($captions as $c) {
        $c->image;
        $c->hashtags;
      }

      return view('home', ['result' => $captions]);
    }

    public function latest()
    {
        $captions = Caption::all()->sortByDesc('created_at');
        foreach ($captions as $c) {
          $c->image;
          $c->hashtags;
        }

        return view('home', ['result' => $captions]);
    }
}
