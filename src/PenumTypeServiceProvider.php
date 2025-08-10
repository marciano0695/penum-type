<?php

namespace Marcionunes\PenumType;

use Illuminate\Support\ServiceProvider;
use Marcionunes\PenumType\Commands\CommandTypeScriptGenerator;
use Marcionunes\PenumType\Commands\EnumPathCommand;

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
                EnumPathCommand::class,
            ]);
        }

        // Auto-copy config if it doesn't exist
        $configPath = config_path('penum-type.php');
        if (! file_exists($configPath)) {
            $this->app->make('files')->copy(
                __DIR__ . '/../config/penum-type.php',
                $configPath
            );
        }
    }
}
