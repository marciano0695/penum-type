<?php

namespace Marcionunes\PenumType;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CommandTypeScriptGenerator extends Command
{
    protected $signature = 'penum-type:generate';

    protected $description = 'Generate a TypeScript file for all enums.';


    public function handle(Filesystem $filesystem)
    {
        $enumsPath = config('penum-type.path');

        if ($filesystem->isDirectory($enumsPath)) {
        }
    }
}
