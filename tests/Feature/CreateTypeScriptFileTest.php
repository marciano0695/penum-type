<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

it('Check values of config file exist on the project', function () {

    $path = config('penum-type.path');

    expect($path)->toBeString();

    $includes = config('penum-type.includes');

    expect($includes)->toBeArray();

    $excludes = config('penum-type.excludes');

    expect($excludes)->toBeArray();

    $output = config('penum-type.output');

    expect($output)->toBeString();
});

it('create file from enum to typescript', function () {

    Config::set('penum-type.path', 'tests/app/Enums');

    Config::set('penum-type.output', 'tests/app/resources/js/types');

    // Get path of enums from config file
    Artisan::call('penum-type:generate');

    expect('tests/app/resources/js/types/enums.d.ts')->toBeFile();
});
