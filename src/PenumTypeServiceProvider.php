<?php

namespace Marcionunes\PenumType;

use Illuminate\Support\ServiceProvider;

class PenumTypeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/penum-type.php', 'penum-type');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/penum-type.php' => config_path('penum-type.php'),
            ], 'penum-type');

            $this->commands([
                CommandTypeScriptGenerator::class,
            ]);
        }
    }
}
