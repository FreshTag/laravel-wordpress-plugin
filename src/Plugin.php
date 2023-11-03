<?php

namespace FreshTag\LaravelWordpressPlugin;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\BootProviders;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Foundation\Bootstrap\RegisterFacades;
use Illuminate\Foundation\Bootstrap\RegisterProviders;
use Illuminate\Support\Facades\Artisan;

class Plugin
{
    /** @var array|string[] */
    protected array $bootstrappers = [
        LoadEnvironmentVariables::class,
        LoadConfiguration::class,
        RegisterFacades::class,
        RegisterProviders::class,
        BootProviders::class,
    ];

    /** @var string $basePath Root dir of plugin */
    private string $basePath;

    /** @var Application  */
    private Application $application;

    /**
     * @param string $basePath
     */
    protected function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return void
     */
    public function bootstrap(): self
    {
        $this->application = new Application($this->basePath);

        $this->application->singleton(
            \Illuminate\Contracts\Console\Kernel::class,
            Console\Kernel::class
        );

        $this->application->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            Exceptions\Handler::class
        );

        $this->application->bootstrapWith($this->bootstrappers);

        return $this;
    }

    /**
     * @return Application|null
     */
    public function getApplication(): ?Application
    {
        return $this->application;
    }

    /**
     * @return void
     */
    public function pluginActivationHook(): void
    {
        if ('production' === env('APP_ENV')) {
            Artisan::call('migrate');
        } else {
            Artisan::call('migrate:fresh', ['--seed' => true]);
        }
    }

    /**
     * @return void
     */
    public function pluginDeactivationHook(): void
    {

    }
}