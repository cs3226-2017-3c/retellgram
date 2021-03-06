<?php

namespace App\Http\Controllers;
use Validator;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Caption;
use App\Image;
use App\Like;
use App\Hashtag;
class DetailController extends Controller
{
  	public function getView($id) {
        $trending_hashtags = Hashtag::withCount('captions')->get()->sortByDesc('captions_count')->slice(0, 10);
        
        $image = Image::findOrFail($id);
        $this->validateImageNotReported($image);
        $path = "/storage/images/" . $image->file_path;
        $og_title = "A place where you can find fun stories!";
  		$query = Input::all();
  		if (array_key_exists('caption_id', $query)) {
            $caption_id = $query['caption_id'];
            $caption = Caption::findOrFail($caption_id);
            $og_title = $caption->content;
            return view('detail',[ 'image_id' => $id, 'image_path' => $path, 'caption_id' => $caption_id, 'og_title' => $og_title, 'hashtags' => $trending_hashtags]);
        } else {
        	return view('detail',[ 'image_id' => $id, 'image_path' => $path, 'caption_id' => -1, 'og_title' => $og_title, 'hashtags' => $trending_hashtags]);
        }
  	}

  	public function getCaption($id) {
  		$caption = Caption::findOrFail($id);
  		return response()->json($caption);
  	}

  	public function getCaptions(Request $request) {
  		$query = Input::all();
        $path_end = "/characters/";
    	//step 1. validate url query
    	if (sizeof($query) == 0) {
    		return ;
    	}
    	$this->validateGetQuery($query);
    	//step 2. retrieve data according to query
        if (array_key_exists('image_id', $query)) {
            $image_id = $query['image_id'];
            $test = Caption::with('character','hashtags')->where('image_id', $image_id);
            $caption = $test->get();
            $test->firstOrFail();
        } else {
            $caption = Caption::All();
        }
    	
        if (array_key_exists('recent', $query) && $query['recent']) {
            $caption = $caption->sortByDesc('updated_at');
        }
        if (array_key_exists('likes', $query) && $query['likes']) {
            $caption = $caption->sortByDesc('likes');
        }

        foreach($caption as $aCaption) {
            $this_id = $aCaption->id;
            if  ($this->validateEligibleToLike($request, $this_id)) {
                $aCaption->liked = false;
            } else {
                $aCaption->liked = true;
            }
            $aCaption->path = $path_end . $aCaption->character->path;
        }

    	return response()->json($caption->values());
  	}

  	public function likeCaption(Request $request, $id) {
  	    $caption = Caption::findOrFail($id);
    	if (!$this->validateEligibleToLike($request, $id)) {
            abort(400, "The IP has liked this caption");
        }
        $this->likeACaption($caption);
        $this->updateLikeTable($request, $id);
    	return response(204);
  	}


    public function deleteCaption(Request $request, $id) {
        $caption = Caption::findOrFail($id);
        $caption->delete(); //doesn't delete permanently

        
        return;
    }

    public function approveCaption(Request $request, $id) {
        $caption = Caption::findOrFail($id);
        $caption->approved = 1;
        return;
    }


  	private function validateGetQuery($query) {
        $validator = Validator::make($query, [
            'image_id' => array('integer'),
            'recent' => array('boolean'),
            'likes' => array('boolean')
        ]);
    	if ($validator->fails()) {
    		$errors = $validator->errors();
            $firstKey = $errors->keys()[0];
            $firstMessage = $errors->first($firstKey);
            abort(404, $firstMessage);
    	}
    }

    private function validateEligibleToLike(Request $request, $id) {
        $cookie = $request->cookie('laravel_session');
        $like = Like::where([
            ['caption_id', $id],
            ['cookie', $cookie]
        ])->get();
        if (sizeof($like)>0) {
            return false;
        } else {
            return true;
        }
    }

    private function validateImageNotReported($image) {
        if ($image->reports > 10) {
            abort(404);
        }
    }

    private function likeACaption($caption) {
        $caption->likes = $caption->likes + 1;
        $caption->save();
    }
    private function updateLikeTable(Request $request, $id) {
        $cookie = $request->cookie('laravel_session');
        Like::create([  'caption_id'    => $id, 
                        'cookie'        => $cookie]);
    }
}
