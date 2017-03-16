<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Caption;
use Validator;

class CreateController extends Controller
{
    public function viewCreate(Request $request) {

    	if ($image_id = $request->input('image_id')){
    		$image = Image::find($image_id);

        	return view('create', [ 'image_path' => $image->file_path, 'chosen' => true ]);
    	}

    	return view('create', [ 'image_path' => "", 'chosen' => false ]);
        
    }

}
