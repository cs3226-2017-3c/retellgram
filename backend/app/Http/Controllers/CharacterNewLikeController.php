<?php

namespace App\Http\Controllers;
use Validator;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\CharacterNewLike;

class CharacterNewLikeController extends Controller
{
  	public function getAll() {
  		$result = CharacterNewLike::all();
  		return response()->json($result);
  	}
}
