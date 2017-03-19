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

        	return view('create', [ 'image_path' => $image->file_path, 'image_id' => $image_id, 'chosen' => true ]);
    	}

    	return view('create', [ 'image_path' => "", 'image_id' => $image_id, 'chosen' => false ]);
        
    }

    // public function chooseImage(Request $request) {

    // 	if ($image_id = $request->input('selectImage')){
    // 		$image = Image::find($image_id);

    //     	return view('create', [ 'image_path' => $image->file_path, 'chosen' => true ]);
    // 	}

    // 	return view('create', [ 'image_path' => "", 'chosen' => false ]);
        
    // }

    public function viewSelectImage() {
        $images = Image::all();

    	return view('selectimage', ['images' => $images, ]);
    }

    public function submitSelectImage(Request $request) {
        Validator::make($request->all(), [ 
            'selectImage' => array('required'),
        ])->validate();

    	if ($image_id = (int)$request->input('selectImage')){

    		if ( $image = Image::find($image_id) ){
    			return redirect()->action('CreateController@viewCreate', [ 'image_id' => $image_id ]);
    		}
        	
    	}

    	return redirect()->action('CreateController@viewCreate');
        
    }

    public function storeCreate(Request $request) {
    	Validator::make($request->all(), [ 
		    'image_id' => array('required'),
		    'caption' => array('required','max:50','regex:/^[A-Za-z1-9,._ ]+$/'),
		])->validate();

    	$new_caption = new Caption;
	    $new_caption->image_id = $request->input('image_id');
	    $new_caption->content = $request->input('caption');
	    $new_caption->likes = 0;
	    $new_caption->save();

    	return view('create', [ 'image_path' => "", 'image_id' => null, 'chosen' => false ]);
    }
    
}
