<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Hashtag;
use App\Caption;

class ProdCaptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
        
    }
}
