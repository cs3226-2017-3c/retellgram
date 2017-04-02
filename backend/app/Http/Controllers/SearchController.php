<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Image;
use App\Caption;
use App\Character;
use App\Hashtag;

use Snipe\BanBuilder\CensorWords;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;
// error_reporting(-1); // reports all errors
// ini_set("display_errors", "1"); // shows all errors
// ini_set("log_errors", 1);
// ini_set("error_log", "/tmp/php-error.log");

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResult( Request $request) {
        $trending_hashtags = Hashtag::withCount('captions')->get()->sortByDesc('captions_count')->slice(0, 10);
        $censor = new CensorWords;
        $langs = array(resource_path('censor/en-base.php'),
            resource_path('censor/en-uk.php'),
            resource_path('censor/en-us.php'),
            resource_path('censor/hokkien.php'));
        $badwords = $censor->setDictionary($langs);

        $search_query= $censor->censorString( trim($request->input('query')) )['clean'];

        if (!$search_query || strpos( $censor->censorString($search_query)['clean'], "*" ) !== false || preg_match("/^[A-Za-z1-9!?;^:()&,._# ]+$/" ,$search_query) === 0) {
          return view('search_not_found' );
        }

        $result = new Collection();

        //hash tag
        if ($search_query[0] == "#") {
            $tags = explode( "#", $search_query );
            $hashtags = new Collection();
            foreach ( $tags as $tag ) {
              $tag = trim($tag);
              if ($tag) {
                if (is_numeric($tag)) {
                  try {
                    $result->push(Image::findOrFail( (int)$tag )->captions->sortByDesc('likes')->first());
                  } catch (ModelNotFoundException $ex) {
                  }

                } else {
                  $similiar_tags = Hashtag::where( "name", 'like','%'.$tag.'%')->get();
                  if ( $similiar_tags->count() ){
                      $hashtags = $hashtags->merge($similiar_tags);
                  }
                }

              }
            }

            foreach ($hashtags as $hashtag) {
              $result = $result->merge($hashtag->captions);
            }

        } else {
          //treat it as one hashtag
          $hashtags = new Collection();
          $similiar_tags = Hashtag::where( "name", 'like','%'.$search_query.'%')->get();
          if ( $similiar_tags->count() ){
            $hashtags = $hashtags->merge($similiar_tags);
          }

          foreach ($hashtags as $hashtag) {
            $result = $result->merge($hashtag->captions);
          }

          $captions = Caption::where('content', 'like' ,'%'.$search_query.'%')->get();
          $result = $result->merge($captions);

        }

        if ( $result->count() === 0){
          return view('search_not_found' );
        }

        foreach ($result as $r) {
            $r->{'image_path'} = Image::find($r->image_id)->file_path;
            $r->{'character_path'} = Character::find($r->character_id)->path;
            $r->{'character_name'} = Character::find($r->character_id)->name;
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentPageSearchResults = $result->slice(($currentPage-1) * $perPage, $perPage)->all();

        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($result), $perPage);


        flash('Search result for "'.$search_query.'".')->important();
        $search_query = str_replace("#", "%23", $search_query);
        $paginatedSearchResults->setPath('search?query='.$search_query);

        return view('search', [ 'result' => $paginatedSearchResults, 'hashtags' => $trending_hashtags] );
    }
}
