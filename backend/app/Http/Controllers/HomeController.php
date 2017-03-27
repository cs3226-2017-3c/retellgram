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
          $i->captions = $i->captions->filter(function ($value, $key) {
              return $value->approved == 1;
          })->sortByDesc('likes')->splice(0, 3);
          foreach ($i->captions as $c) {
            $c->character;
          }
        }

        return view('home', ['result' => $images]);
        return $images;
    }
}
