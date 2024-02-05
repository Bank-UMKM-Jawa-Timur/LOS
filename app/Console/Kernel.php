<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $schedule->command('pembayaran:cron')
                ->daily()
                ->appendOutputTo(storage_path('logs/console.log'));
        // $schedule->command('backup:clean')->daily()->at('22:30')->appendOutputTo(storage_path('logs/laravel.log'));
        // $schedule->command('backup:run')->daily()->at('00:00')->appendOutputTo(storage_path('logs/laravel.log'));
        // $schedule->command('backup:clean')->everyMinute()->appendOutputTo(storage_path('logs/laravel.log'));
        // $schedule->command('backup:run')->everyMinute()->appendOutputTo(storage_path('logs/laravel.log'));
        $schedule->command('backup:clean')->daily()->at('01:58')->appendOutputTo(storage_path('logs/laravel.log'));
        $schedule->command('backup:run --only-db')->daily()->at('01:58')->appendOutputTo(storage_path('logs/laravel.log'));
        $schedule->command('onedrive:cron')->daily()->at('01:58')->appendOutputTo(storage_path('logs/laravel.log'));
        $schedule->command('backup:monitor')->daily()->at('01:58')->appendOutputTo(storage_path('logs/laravel.log'));
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
