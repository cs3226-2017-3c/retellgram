<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Caption;
use App\Image;

class TestViewController extends Controller
{
    public function getTestView() {
        return response()->view('testView');
    }
}
