<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Hashtag;
use Intervention\Image\ImageManager;

use Validator;
use Response;

class UploadControllerNew extends Controller
{
    public function viewUpload() {
        $trending_hashtags = Hashtag::withCount('captions')->get()->sortByDesc('captions_count')->slice(0, 10);
        
        return view('new_upload',['hashtags' => $trending_hashtags]);
    }
   

   	public function storeUpload( Request $request) {
   		Validator::make($request->all(), [ 
		    'uploading' => 'required|max:25600|image',
		  ])->validate();

      $manager = new ImageManager();

      $img = $manager->make( $request->file('uploading'));

      $img->resize(1000, null, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
      });

   		$new_image = new Image();
	    $new_image->md5 = md5_file ($request->file('uploading'));

	   	if ( $exist_image = Image::where('md5', $new_image->md5)->first() ) {
        flash('Image #'.$new_image->id." exists, add caption directly.", 'success');
		    return redirect()->action('CreateControllerNew@viewCreate',[ 'image_id' => $exist_image->id]);
		  }
	    
      $ext = $request->file('uploading')->extension();
      $name = time().uniqid();
      $filename = $name.'.'.$ext;

      $img->save(public_path("storage/images/".$filename) , 70);
      	
      $new_image->file_path = $filename;

    	$new_image->save();

      flash('New image #'.$new_image->id." was uploaded successfully!", 'success');

    	return redirect()->action('CreateControllerNew@viewCreate',[ 'image_id' => $new_image->id]);
   	}

}