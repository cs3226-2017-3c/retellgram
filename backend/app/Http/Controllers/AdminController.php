<?php

namespace App\Http\Controllers;
use Response;

use App\Caption;
use App\Image;
class AdminController extends Controller
{
  public function admin() {
    $images = Caption::All();
    $unverified = [];
    foreach ($images as $i) {
      if (!$i->approved) {
      	array_push($unverified, $i);
      }
    }
    return view('admin',[ 'unverified' => $unverified]);
  }
}
