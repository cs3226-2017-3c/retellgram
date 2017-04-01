<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;

use App\Caption;
use App\Image;
class AdminController extends Controller
{

  public function __construct() {
    $this->middleware('auth');
  }

  public function admin() {
    $images = Image::All()->sortByDesc('created_at');
    return view('admin',[ 'images' => $images]);
  }

  public function adminCaption(Request $request, $id) {
    $captions = Image::findOrFail($id)->captions->sortByDesc('created_at');
    return view('adminCaption',[ 'captions' => $captions]);
  }

  public function deleteImage(Request $request, $image_id) {
    $image = Image::findOrFail($image_id);
    $captions = $image->captions;
    foreach($captions as $caption){
      $caption->delete();
    }
    $image->delete();
    $images = Image::All()->sortByDesc('created_at');
    return redirect()->action('AdminController@admin',['images' => $images]);
  }

  public function deleteCaption(Request $request, $id) {
      $caption = Caption::findOrFail($id);
      $image_id = $caption->image_id;
      $caption->delete(); //doesn't delete permanently

      return redirect()->action('AdminController@adminCaption',['id' => $image_id]);;
  }


}
