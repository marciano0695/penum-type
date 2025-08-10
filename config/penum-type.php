<?php

declare(strict_types=1);

return [
    'path' => 'app/Enums',

    'output' => resource_path('js/types/enums'),

    'enum_method_to_export' => 'frontend',

    'export_constants' => false, // WIP

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
