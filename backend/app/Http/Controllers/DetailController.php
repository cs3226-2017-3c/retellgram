<?php

namespace App\Http\Controllers;
use Validator;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Caption;
use App\Image;
use App\Like;
class DetailController extends Controller
{
  	public function getView($id) {
  		$query = Input::all();
  		if (array_key_exists('caption_id', $query)) {
            $caption_id = $query['caption_id'];
            return view('detail',[ 'image_id' => $id, 'caption_id' => $caption_id]);
        } else {
        	return view('detail',[ 'image_id' => $id, 'caption_id' => 0]);
        }
  	}

  	public function getImage($id) {
    	$image = Image::findOrFail($id);
    	$path = "/storage/images/" . $image->file_path;
    	$result = array("path"=>$path);
    	return response()->json($result);
  	}

  	public function getCaption($id) {
  		$caption = Caption::findOrFail($id);
  		return response()->json($caption);
  	}

  	public function getCaptions() {
  		$query = Input::all();
    	//step 1. validate url query
    	if (sizeof($query) == 0) {
    		return ;
    	}
    	$this->validateGetQuery($query);
    	//step 2. retrieve data according to query
        if (array_key_exists('image_id', $query)) {
            $image_id = $query['image_id'];
            $test = Caption::where('image_id', $image_id);
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

    	return response()->json($caption->values());
  	}

  	public function likeCaption(Request $request, $id) {
  	    $caption = Caption::findOrFail($id);
    	//$this->validateEligibleToLike($request, $id);
        $this->likeACaption($caption);
        //$this->updateLikeTable($request, $id);
    	return response(204);
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
        $ip = $request->ip();
        $like = Like::where([
            ['caption_id', $id],
            ['ip', $ip]
        ])->get();
        if (sizeof($like)>0) {
            abort(400, "The IP has liked this caption");
        }
    }
    private function likeACaption($caption) {
        $caption->likes = $caption->likes + 1;
        $caption->save();
        $image = Image::findOrFail($caption->image_id);
        $image->likes = $image->likes + 1;
        $image->save();
    }
    private function updateLikeTable(Request $request, $id) {
        $ip = $request->ip();
        Like::create([  'caption_id'    => $id, 
                        'ip'            => $ip]);
    }
}
