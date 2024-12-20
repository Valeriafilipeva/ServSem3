<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendStatisticsEmail; // Подключаем команду

class Kernel extends ConsoleKernel
{
    /**
     * Регистрация команд приложения.
     *
     * @var array
     */
    protected $commands = [
        SendStatisticsEmail::class,  // Регистрация команды
        // Здесь регистрируются все команды, которые должны быть доступны через консоль
    ];

    /**
     * Определение расписания команд.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Пример расписания команды:
        $schedule->command('email:send-statistics')->daily();
    }

    /**
     * Регистрация сторонних команд.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
