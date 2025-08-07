<?php

declare(strict_types=1);

return [
    'path' => 'app/Enums',

    'output' => 'resources/js/types',

    'fileName' => 'enums.ts',

    'fileNameDeclaration' => 'enums.d.ts',

    /**
     * Specific which to include when is empty will include all files
     * E.g. AddressTypeEnum::class
     */
    'includes' => [],

    /**
     * Specific which to exclude when is empty will ignore
     * E.g. AddressTypeEnum::class
     */
    'excludes' => []
];
