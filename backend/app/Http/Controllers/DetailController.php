<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;

use App\Caption;
use App\Image;
class DetailController extends Controller
{
  	public function getView($id) {
  		return view('detail',[ 'image_id' => $id]);
  	}

  	public function getImage($id) {
    	$image = Image::findOrFail($id);
    	$path = "/storage/images/" . $image->file_path;
    	$result = array("path"=>$path);
    	return response()->json($result);
  	}

  	public function getCaptions($image_id) {
  		$caption = Caption::where('image_id', $image_id);
  		$result = $caption->orderBy('likes', 'desc')->get();
  		$caption->firstOrFail();
  	
  		return response()->json($result);
  	}

  	public function likeCaption(Request $request, $id) {
  	    $caption = Caption::findOrFail($id);
    	$this->validateEligibleToLike($request, $id);
        $this->likeACaption($caption);
        $this->updateLikeTable($request, $id);
    	return response(204);
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
