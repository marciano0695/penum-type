<?php

namespace App\Enums;

enum PriorityEnum: int
{
    case LOWEST = 1;
    case LOW = 2;
    case MEDIUM = 3;
    case HIGH = 4;
    case HIGHEST = 5;
}
