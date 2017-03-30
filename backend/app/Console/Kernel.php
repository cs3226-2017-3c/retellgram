<?php

namespace App\Console;

use Log;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\CharacterNewLike;
use App\Like;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Calculate new likes for each character for each hour
        
        $schedule->call(function () {
            Log::info('Calculating new likes for each character...');
            $last_hour = new Carbon();
            $last_hour->subHour();
            $last_hour = $last_hour->toDateTimeString();
            $newLikeRecords = Like::select('caption_id', \DB::raw('count(*) as new_like'))->
            whereDate('updated_at', '>', $last_hour)->groupBy('caption_id')->get();

            foreach($newLikeRecords as $aRecord) {
                $CharacterNewLike = new CharacterNewLike;
                $CharacterNewLike->caption_id = $aRecord->caption_id;
                $CharacterNewLike->new_like = $aRecord->new_like;
                $CharacterNewLike->save();
            }
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
