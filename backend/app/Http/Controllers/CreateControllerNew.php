<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Caption;
use App\Hashtag;
use App\Character;
use Validator;
use Snipe\BanBuilder\CensorWords;
use Mews\Purifier\Facades\Purifier;
// error_reporting(-1); // reports all errors
// ini_set("display_errors", "1"); // shows all errors
// ini_set("log_errors", 1);
// ini_set("error_log", "/tmp/php-error.log");

class CreateControllerNew extends Controller
{
    public function viewCreate(Request $request) {
        $trending_hashtags = Hashtag::withCount('captions')->get()->sortByDesc('captions_count')->slice(0, 10);
        
        $images = Image::all();
        $characters = Character::all();

    	if ($image_id = $request->input('image_id')){
    		$image = Image::find($image_id);

        	return view('new_create', [ 'characters' => $characters ,'images' => $images,'image_path' => $image->file_path, 'image_id' => $image_id, 'hashtags' => $trending_hashtags ]);
    	}

    	return view('new_create', ['characters' => $characters, 'images' => $images, 'image_path' => "", 'image_id' => $image_id, 'hashtags' => $trending_hashtags ]);
        
    }

    public function storeCreate(Request $request) {
    	Validator::make($request->all(), [ 
		    'image_id' => array('required'),
		    'caption' => array('required','max:100'),
            'character_id' => array('required','in:1,2,3,4,5,6,7,8,9,10,11,12'),
            'hashtags' => array('nullable', 'max:50','regex:/(#[A-Za-z1-9]+(\s+)?){0,5}/'),
		])->validate();

        $censor = new CensorWords;

        $langs = array(resource_path('censor/en-base.php'),
            resource_path('censor/en-uk.php'),
            resource_path('censor/en-us.php'),
            resource_path('censor/hokkien.php'));
        $badwords = $censor->setDictionary($langs);

    	$new_caption = new Caption;
	    $new_caption->image_id = $request->input('image_id');

        $content = Purifier::clean($request->input('caption'));
	    $new_caption->content = $censor->censorString($content)['clean'];
	    $new_caption->likes = 0;
        $new_caption->character_id = $request->input('character_id');
        //$new_caption->approved = true;
        $new_caption->save();


        $tag_string = $request->input('hashtags');
        $tags = explode( "#", $tag_string );
        $tag_ids = array();

        foreach ( $tags as $tag ) {
            if ($tag && strpos( $censor->censorString($tag)['clean'], "*" ) === false) {
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

        flash('Caption for image #'.$new_caption->image_id." was created successfully!", 'success')->important();

        return redirect()->action('DetailController@getView',['id' => $new_caption->image_id]);
    }
    
}