<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Caption;
use App\Hashtag;
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
        //hashtag validation do in frontend
    	Validator::make($request->all(), [ 
		    'image_id' => array('required'),
		    'caption' => array('required','max:50','regex:/^[A-Za-z1-9,._ ]+$/'),
            'character' => array('required','in:1,2,3,4,5,6,7,8,9,10,11,12'),
		])->validate();

    	$new_caption = new Caption;
	    $new_caption->image_id = $request->input('image_id');
	    $new_caption->content = $request->input('caption');
	    $new_caption->likes = 0;
        $new_caption->character_id = $request->input('character');
        $new_caption->approved = false;
        $new_caption->save();


        $tag_string = $request->input('hashtags');
        $tags = explode( "#", $tag_string );
        $tag_ids = array();

        foreach ( $tags as $tag ) {
            if ($tag) {
                if ( Hashtag::where( "name", $tag)->count() ){
                    $hashtag= Hashtag::where( "name", $tag)->first();
                    array_push($tag_ids, $hashtag->id);
                } else {
                    $new_tag = new Hashtag;
                    $new_tag->name = trim($tag, " ");
                    $new_tag->save();
                    array_push($tag_ids, $new_tag->id);
                }
            } 
        }

        foreach ( $tag_ids as $tag_id) {
            $new_caption->hashtags()->attach($tag_id);
        }

    	return view('create', [ 'image_path' => "", 'image_id' => null, 'chosen' => false ]);
    }
    
}
