<?php

namespace App\Console;

use App\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use phpseclib\Net\SSH2;

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
//            Order::where("id",3)->delete();
            $host = "185.51.202.111";
            $username = "root";
            $password = "Ehsan123";
            $command = 'rmdir imanTestDirctory';

            $ssh = new SSH2($host);
            if (!$ssh->login($username, $password)) {
                $output ='Login Failed';
            }
            else{
                $output = $ssh->exec($command);
            }
        })->everyMinute();
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
