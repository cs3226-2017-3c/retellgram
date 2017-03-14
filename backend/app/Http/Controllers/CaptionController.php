<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Caption;
use App\Image;
use App\Like;

class CaptionController extends Controller
{
	public function createCaption(Request $request) {
		$body = json_decode($request->getContent(), true);
		$this->validateCreateCaption($body);
		$this->validateImageExist($body['image_id']);

		$new_caption = new Caption;

		$new_caption->image_id = $body['image_id'];
		$new_caption->content = $body['content'];
		$new_caption->likes = 0;
		$new_caption->save();

		return response($new_caption->id);
	}

    public function getCaptions() {
        
        $captions = Caption::All();

        return response()->json($captions);
    }

    public function getCaption($id) {
    	$caption = Caption::findOrFail($id);

    	return response()->json($caption);
    }

    public function getCaptionsWithQuery() {
        //type of query:
        //a. image_id=<image_id>: retrieve captions with image_id equals to <image_id>
        //b. recent=1 or 0(default): retrieve most recent captions
        //c. likes=1 or 0(default): retrieve most liked captions

    	$query = Input::all();
    	//step 1. validate url query
    	if (sizeof($query) == 0) {
    		return $this->getCaptions();
    	}
    	$this->validateGetQuery($query);

    	//step 2. retrieve data according to query
        if (array_key_exists('image_id', $query)) {
            $image_id = $query['image_id'];
            $caption = Caption::where('image_id', $image_id)->firstOrFail()->get();
        } else {
            $caption = Caption::All();
        }
    	
        if (array_key_exists('recent', $query) && $query['recent']) {
            $caption = $caption->sortByDesc('updated_at');
        }

        if (array_key_exists('likes', $query) && $query['likes']) {
            $caption = $caption->sortByDesc('likes');
        }

        $caption = $this->getTopN($caption, 20);
    	return response()->json($caption);
    }

    public function likeCaption(Request $request, $id) {
        $caption = Caption::findOrFail($id);
    	$this->validateEligibleToLike($request, $id);
        $this->likeACaption($caption);
        $this->updateLikeTable($request, $id);

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

    private function validateCreateCaption($body) {
    	$validator = Validator::make($body, [
            'image_id' => array('required','integer'),
            'content' => array('required','min:1','max:50','regex:/^[A-Za-z0-9,._ ]+$/'),
        ]);

    	if ($validator->fails()) {
            $errors = $validator->errors();
            $firstKey = $errors->keys()[0];
            $firstMessage = $errors->first($firstKey);
            abort(400, $firstMessage);
        }
    }

    private function validateImageExist($image_id) {
    	$images = Image::findOrFail($image_id);
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

    private function getTopN($collection, $n) {
        return $collection->slice(0, $n);
    }
}
