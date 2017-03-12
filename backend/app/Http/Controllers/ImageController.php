<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caption;
use App\Image;

class ImageController extends Controller
{
    public function getImages() {
        $images = Image::All();

        return response()->json($images);
    }

    public function getImage($id) {
    	$images = Image::find($id);

        $path = $images->file_path;

        return response()->file($path);
    }
}
