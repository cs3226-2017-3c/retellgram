<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

use Validator;
use Intervention\Image\ImageManager;
use Faker\Factory as Faker;
use Response;

error_reporting(-1); // reports all errors
ini_set("display_errors", "1"); // shows all errors
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");

class UploadController extends Controller
{
    public function viewUpload() {
        return view('upload');
    }
   

   	public function storeUpload( Request $request) {
   		Validator::make($request->all(), [ 
		    'uploading' => 'required|max:1024|image',
		])->validate();

   		$new_image = new Image();
	    
	   	//if ( Images::where('md5', $new_image->md5)->count() != 0 ) {
		    	// TODO: show "image exist, go to add caption"
		//}
	    
      	$path = $request->file('uploading')->store("public/images");
      	
      	$new_image->file_path = basename($path);
    	$new_image->md5 = md5_file ($request->file('uploading'));
    	$new_image->likes = 0;

    	$new_image->save();

    	return redirect()->action('CreateController@viewCreate',[ 'image_id' => $new_image->id ]);
   	}


    public function cropUpload( Request $request) {
    	if($request->ajax()){
	      	$data = $request->image;
	      	$path = $this->saveImage($data);
	      	$new_image = new Image();
	      	$new_image->file_path = $path;
	      	$new_image->likes = 0;

	      	$new_image->md5 = md5_file ($data);
		    //if ( Images::where('md5', $new_image->md5)->count() != 0 ) {
		    	// TODO: show "image exist, go to add caption"
		    	//abort("400");
		    //}
	      
	      	if($new_image->save())
	      	{
	          	return Response::json(
	              ['message'=>"completed", 'image_id' => $new_image->id],200
	          	);
	      	}
	      	else {
	        	return Response::json(['message'=>'not uploaded'],500);
	      	}
	    }
	    return Response::json(
	              ['message'=>"not ajax call"],500
	    );
    }

    private function saveImage($data){
	    $filename = $this->randomName();
	    list($type, $data) = explode(';', $data);
	    list(, $data)      = explode(',', $data);
	    $data = base64_decode($data);
	    file_put_contents(storage_path()."/app/public/images/".$filename.'.png', $data);
	    return $filename.'.png';
	}

	private function randomName(){
	    $faker = Faker::create();
	    return $faker->sha1;
	}

}
