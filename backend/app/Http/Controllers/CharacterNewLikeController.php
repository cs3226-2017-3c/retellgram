<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Validator;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;

use App\CharacterNewLike;
use App\Caption;
use App\Like;

class CharacterNewLikeController extends Controller
{
  	public function getAll() {
  		$result = CharacterNewLike::all();
  		return response()->json($result);
  	}

    public function getNewLikes() {
        $result = new Collection();
            $last_hour = new Carbon();
            $last_hour->subHour();
            $newLikeRecords = Like::join('captions', 'captions.id', '=', 'like.caption_id')
            ->where('like.created_at', '>', $last_hour)->groupBy('captions.character_id')
            ->get([\DB::raw('captions.character_id as character_id'), \DB::raw('count(*) as new_like')]);
            foreach($newLikeRecords as $aRecord) {
                $characterNewLike = new CharacterNewLike;
                $characterNewLike->character_id = $aRecord->character_id;
                $characterNewLike->new_like = $aRecord->new_like;
                $result->push($characterNewLike);
            }
        return response()->json($result);
    }

    public function getLikes() {
        $likes = Like::all();

        return response()->json($likes);
    }
}
