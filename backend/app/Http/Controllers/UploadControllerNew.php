<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

use Validator;
use Response;

class UploadControllerNew extends Controller
{
    public function viewUpload() {
        return view('new_upload');
    }
   

   	public function storeUpload( Request $request) {
   		Validator::make($request->all(), [ 
		    'uploading' => 'required|max:2048|image',
		])->validate();

   		$new_image = new Image();
	    $new_image->md5 = md5_file ($request->file('uploading'));

	   	if ( $exist_image = Image::where('md5', $new_image->md5)->first() ) {
		    return redirect()->action('CreateControllerNew@viewCreate',[ 'image_id' => $exist_image->id, 'character_id' => null ]);
		}
	    
      	$path = $request->file('uploading')->store("public/images");
      	
      	$new_image->file_path = basename($path);
    	$new_image->md5 = md5_file ($request->file('uploading'));
    	$new_image->likes = 0;

    	$new_image->save();

    	return redirect()->action('CreateController@viewCreate',[ 'image_id' => $new_image->id, 'character_id' => null ]);
   	}

}