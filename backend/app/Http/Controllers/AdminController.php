<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;

use App\Caption;
use App\Image;
use Storage;
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

  public function adminReport() {
    $images = Image::where("reports",">",0)->get();
    return view('admin',[ 'images' => $images]);
  }

  public function deleteImage(Request $request, $image_id) {
    $image = Image::findOrFail($image_id);
    $captions = $image->captions;
    foreach($captions as $caption){
      $caption->delete();
    }
    Storage::delete('public/images/'.$image->file_path);
    $image->delete();
    return redirect()->action('AdminController@admin');
  }

  public function resetImageReport(Request $request, $image_id) {
    $image = Image::findOrFail($image_id);
    $image->reports = 0;
    $image->save();

    return redirect()->action('AdminController@adminReport');
  }

  public function deleteCaption(Request $request, $id) {
      $caption = Caption::findOrFail($id);
      $image_id = $caption->image_id;
      $caption->delete(); //doesn't delete permanently

      return redirect()->action('AdminController@adminCaption',['id' => $image_id]);;
  }


}
