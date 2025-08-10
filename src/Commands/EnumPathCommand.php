<?php

namespace Marcionunes\PenumType\Commands;

use Illuminate\Console\Command;

class EnumPathCommand extends Command
{
    protected $signature = 'penum-type:path';

    public function handle()
    {
        $this->line(config('penum-type.path'));
    }
}
