<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        // 注：Laravel 5.5 版本起，我们不再需要手动去注册 Artisan 命令，Laravel 会自动扫描 app/Console/Commands/ 目录下的代码并加载。
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command("cron:finish-crowdfunding")->everyMinute();
        // daily() 代表每天凌晨 00:00 执行
        $schedule->command('cron:calculate-installment-fine')->daily();
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
