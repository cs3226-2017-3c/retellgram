<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Hashtag;
use App\Caption;

class CaptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();
    	$limit = 50;

    	$test_images_path="public/images/";

    	$test_images = ["test-01.png",
    					"test-02.png",
    					"test-03.png",
    					"test-04.png",
    					"test-05.png",
    					"test-06.png",
    					"test-07.png",
    					"test-08.png",
    					"test-09.png"];

        // seed image
        foreach ($test_images as $image) {
            DB::table('images')->insert([
                'file_path' => $image,
                'md5' => md5_file ( storage_path('app/'. $test_images_path . $image)),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        // seed character
        $factions = config('characters.factions');

        foreach ($factions as $faction => $characters) {
            foreach ( $characters as $character => $path ) {
                DB::table('characters')->insert([
                'name' => $character,
                'faction' => $faction,
                'path' => $path
                ]);
            }
        }

        // seed hashtags
        $default_tags = config('tags.hashtags');
        foreach ( $default_tags as $tag ) {
            DB::table('hashtags')->insert([
                'name' => $tag,
            ]);
        }

        // seed caption

        for ($i = 0; $i < $limit; $i++) {
            DB::table('captions')->insert([
                'image_id' => $faker->numberBetween(1, sizeof( $test_images)),
                'content' => $faker->text($maxNbChars = 50),
                'likes' => $faker->numberBetween(1,100),
                'approved' => true,
                'character_id' => $faker->numberBetween(1, 12),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        }

        // seed caption_hashtag
        $tags = Hashtag::pluck('id');

        $last = count($tags) - 1;
        $captions = Caption::all();

        if (count($tags)) {
            foreach( $captions as $caption ) {
                $caption->hashtags()->attach( $tags[ $faker->numberBetween(0, $last) ] );
            }
        }

    }
}
