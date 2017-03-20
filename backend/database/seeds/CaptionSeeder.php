<?php

use Illuminate\Database\Seeder;

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

        foreach ($test_images as $image) {
            DB::table('images')->insert([
                'file_path' => $image,
                'md5' => md5_file ( storage_path('app/'. $test_images_path . $image)),
                'likes' => $faker->numberBetween(1,100)
            ]);
        }

        for ($i = 0; $i < $limit; $i++) {
            DB::table('captions')->insert([
                'image_id' => $faker->numberBetween(1, sizeof( $test_images)),
                'content' => $faker->text($maxNbChars = 50),
                'likes' => $faker->numberBetween(1,100)
            ]);
        }

    }
}
