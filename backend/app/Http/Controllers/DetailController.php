<?php

namespace App\Http\Controllers;
use Response;

use App\Caption;
use App\Image;
class DetailController extends Controller
{
  public function getView($id) {
  	return view('detail',[ 'image_id' => $id]);
  }

  public function getImage($id) {
    $image = Image::findOrFail($id);
    $path = "storage/images/" . $image->file_path;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return response($base64);
  }

  public function getCaptions($image_id) {
  	$caption = Caption::where('image_id', $image_id);
  	$result = $caption->orderBy('likes', 'desc')->get();
  	$caption->firstOrFail();
  	
  	return response()->json($result);
  }
}
