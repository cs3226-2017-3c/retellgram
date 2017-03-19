<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

use Validator;
use Intervention\Image\ImageManager;
use Faker\Factory as Faker;

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

    	$data = $_POST['image'];

		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);

		$data = base64_decode($data);
		$imageName = time().'.png';
		file_put_contents('upload/'.$imageName, $data);

		echo 'done';

        Validator::make($request->all(), [ // as simple as this
	      'img' => 'max:1024|image',
	      ])->validate();

        $form_data = Input::all();

        $upload_image = $form_data['img'];

        $new_image = new Image;

        $new_image->md5 = md5_file ($upload_image);
	    if ( Images::where('md5', $new_image->md5)->count() != 0 ) {
	    	// TODO: show "image exist, go to add caption"
	    	abort("400");
	    }

        $original_name = $upload_image->getClientOriginalName();
        $original_name_without_ext = substr($original_name, 0, strlen($upload_image) - 4);

        $filename = $this->sanitize($original_name_without_ext);
        $allowed_filename = $this->createUniqueFilename( $filename );

        $filename_ext = $allowed_filename .'.jpg';

     //    $manager = new ImageManager();
     //    $image = $manager->make( $upload_image )->encode('jpg')->save(public_path()."/storage/images/" . $filename_ext );

     //    if( !$image) {

     //        return Response::json([
     //            'status' => 'error',
     //            'message' => 'Server error while uploading',
     //        ], 200);

     //    }
	    
	    // $new_image->likes = 0;
	    // $new_image->file_path = $filename_ext;


	    // $new_image->save();

        return Response::json([
            'status'    => 'success',
            'url'       => 'storage/images/' . $filename_ext,
            'width'     => $image->width(),
            'height'    => $image->height()
        ], 200);
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
	              ['message'=>"completed"],200
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
