<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

use Validator;

class UploadController extends Controller
{
    public function viewUpload() {
        return view('upload');
    }

    public function storeUpload( Request $request) {

        Validator::make($request->all(), [ // as simple as this
	      'avatar' => 'max:1024|image',
	      ])->validate();

	    $new_image = new Image;

	    // check md5 
	    $new_image->md5 = md5_file ($request->file('avatar'));
	    if ( Images::where('md5', $new_image->md5)->count() != 0 ) {
	    	// TODO: show "image exist, go to add caption"
	    	abort("400");
	    }

	    if($request->hasFile('avatar')){
	      $path = $request->file('avatar')->store("public/images");
	      $new_image->file_path = $path;
	    } else {
	    	abort("400");
	    }

	    
	    $new_image->likes = 0;

	    $new_image->save();
	    return redirect()->action('UploadController@viewUpload');
    }

}
