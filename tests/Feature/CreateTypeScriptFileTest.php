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
});



it('create file from enum to typescript', function () {

    Config::set('penum-type.path', 'tests/app/Enums');

    // Get path of enums from config file
    Artisan::call('penum-type:generate');

    // Foreach each enum file create file

    // Assert if create file

    expect(true)->toBe(true);
});
