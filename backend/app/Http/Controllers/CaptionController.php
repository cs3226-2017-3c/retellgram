<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Caption;
use App\Image;

class CaptionController extends Controller
{
	public function createCaption(Request $request) {
		$body = json_decode($request->getContent(), true);
		$this->validateCreateCaption($body);
		$this->validateImageExist($body["image_id"]);

		$new_caption = new Caption;

		$new_caption->image_id = $body["image_id"];
		$new_caption->content = $body["content"];
		$new_caption->likes = 0;
		$new_caption->save();

		return response($new_caption->id);
	}

    public function getCaptions() {
        
        $captions = Caption::All();

        return response()->json($captions);
    }

    public function getCaption($id) {
    	$caption = Caption::find($id);

    	$this->checkResult($caption);
    	return response()->json($caption);
    }

    public function getCaptionsWithQuery() {
    	$query = Input::all();
    	//step 1. validate url query
    	if (sizeof($query) == 0) {
    		return $this->getCaptions();
    	}
    	$this->validateGetQuery($query);

    	//step 2. retrieve data according to query
    	$image_id = $query["image_id"];
    	$caption = Caption::where("image_id", $image_id)->get();

    	$this->checkResult($caption);
    	return response()->json($caption);
    }

    public function likeCaption($id) {
    	$caption = Caption::find($id);
    	$caption->likes = $caption->likes + 1;
    	$caption->save();

    	return response(204);
    }

    private function validateGetQuery($query) {
    	//naive validate: the url query must conatin image_id parameter
    	if (!array_key_exists("image_id", $query)) {
    		abort(404, 'Page Not Found');
    	}	
    }

    private function validateCreateCaption($body) {
    	$validator = Validator::make($body, [
            'image_id' => array('required','integer'),
            'content' => array('required','min:1','max:50','regex:/^[A-Za-z0-9,._ ]+$/'),
        ]);

    	if ($validator->fails()) {
            abort(400, 'Bad Request');
        }
    }

    private function validateImageExist($image_id) {
    	$images = Image::find($image_id);
    	$this->checkResult($images);
    }

    private function checkResult($array) {
    	if (sizeof($array) == 0) {
    		abort(404, 'Page Not Found');
    	}
    }
}
