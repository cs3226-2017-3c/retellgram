<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class UploadController extends Controller
{
    public function viewUpload() {
        return view('upload');
    }

}
