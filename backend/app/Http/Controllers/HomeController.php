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
        $images = Image::all()->sortByDesc('likes');
        foreach ($images as $i) {
          $i->caption = $i->captions->sortByDesc('likes')->first();
          if($i->caption){
            $i->caption->character;
          }
        }

        return view('home', ['result' => $images]);
    }

    public function latest()
    {
        $captions = Caption::all()->sortByDesc('created_at');
        foreach ($captions as $c) {
          $c->image;
        }

        return view('latest', ['result' => $captions]);
    }
}
