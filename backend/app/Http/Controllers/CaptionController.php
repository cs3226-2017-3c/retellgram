<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caption;
use App\Image;

class CaptionController extends Controller
{
    public function getCaptions() {
        
        $captions = Caption::All();

        return response()->json($captions);
    }

    public function getImages() {
        
        $images = Image::All();

        return response()->json($images);
    }
}
