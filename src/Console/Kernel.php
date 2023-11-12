<?php

namespace FreshTag\LaravelWordpressPlugin\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    private array $commandDirs;

    public function __construct(Application $app, Dispatcher $events)
    {
        parent::__construct($app, $events);

        $this->commandDirs = [__DIR__.'/Commands'];
    }

    public function addCommandDir($path): void
    {
        $this->commandDirs[] = $path;
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load($this->commandDirs);
    }
}
