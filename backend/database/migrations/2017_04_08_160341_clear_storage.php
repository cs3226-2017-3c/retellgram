<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Image;
use Illuminate\Support\Facades\Storage;

class ClearStorage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $directory = storage_path("app/public/images");

        $images = glob($directory . "/*");

        foreach($images as $image) {
            echo $image;
            $count = Image::where('file_path',basename($image))->count();
            if ($count == 0) {
                unlink($image);
            }
   
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
