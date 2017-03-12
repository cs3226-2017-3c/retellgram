<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Caption;
use App\Image;

class CaptionController extends Controller
{
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
    	$this->validateQuery($query);

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

    private function validateQuery($query) {
    	//naive validate: the url query must conatin image_id parameter
    	if (!array_key_exists("image_id", $query)) {
    		abort(404, 'Page Not Found');
    	}	
    }

    private function checkResult($array) {
    	if (sizeof($array) == 0) {
    		abort(404, 'Page Not Found');
    	}
    }
}
