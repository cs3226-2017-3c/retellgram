<?php

namespace App\Http\Controllers;
use Response;

use App\Caption;
use App\Image;
class HomeController extends Controller
{
  public function home() {
    $images = Image::All();
    foreach ($images as $i) {
      $i->popular = $i->captions->sortByDesc('likes')->first();
    }
    return view('home',[ 'result' => $images]);
  }
}
