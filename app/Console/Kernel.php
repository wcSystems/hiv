<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\User;
use App\Contract;
use Notification;
use Carbon\Carbon;

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
        $schedule->call(function () {
            $users = User::all();
            $contracts = Contract::all();
            $now = Carbon::now();
            foreach($contracts as $contract){
                if($contract->end_date != null){
                    $start_date = new Carbon($contract->start_date);
                    $end_date = new Carbon($contract->end_date);
                    $end_date_aux = new Carbon($end_date);
                    $end_date_aux = $end_date_aux->subDays(5);
                    if($now->lessThanOrEqualTo($end_date) && $now->greaterThanOrEqualTo($end_date_aux)){
                        Notification::send($users, new ContractFinishing($contract));
                    }
                }
            }
        })->daily();
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
