<?php

declare(strict_types=1);

return [
    'path' => 'app/Enums',

    'output' => resource_path('types/enums'),

    /**
     * Specific which to include when is empty will include all files
     * E.g. AddressTypeEnum::class
     */
    'includes' => [],

    /**
     * Specific which to exclude when is empty will ignore
     * E.g. AddressTypeEnum::class
     */
    'excludes' => [],
];
