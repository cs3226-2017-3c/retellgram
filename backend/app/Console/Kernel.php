<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\CharacterNewLike;
use App\Caption;
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
            $last_hour = new Carbon();
            $last_hour->subHour();
            $newLikeRecords = Like::join('captions', 'captions.id', '=', 'like.caption_id')
            ->where('like.created_at', '>', $last_hour)->groupBy('captions.character_id')
            ->get([\DB::raw('captions.character_id as character_id'), \DB::raw('count(*) as new_like')]);
            foreach($newLikeRecords as $aRecord) {
                $characterNewLike = new CharacterNewLike;
                $characterNewLike->character_id = $aRecord->character_id;
                $characterNewLike->new_like = $aRecord->new_like;
                $characterNewLike->save();
            }
        })->hourly();
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
