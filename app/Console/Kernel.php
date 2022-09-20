<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('customEvent:daily')->daily();

        $date = Carbon::now();
        $schedule->command('customEvent:monthly')->monthly();
        $schedule->command('customEvent:monthly --month=2')->monthly()->when(function () use($date){
            return ($date->month % 2) === 0;
        });
        $schedule->command('customEvent:monthly --month=3')->monthly()->when(function () use($date){
            return ($date->month % 3) === 0;
        });
        $schedule->command('customEvent:monthly --month=4')->monthly()->when(function () use($date){
            return ($date->month % 4) === 0;
        });
        $schedule->command('customEvent:monthly --month=6')->monthly()->when(function () use($date){
            return ($date->month % 6) === 0;
        });;

        $schedule->command('customEvent:weekly')->daily();

        $schedule->command('customEvent:yearly')->yearly();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
