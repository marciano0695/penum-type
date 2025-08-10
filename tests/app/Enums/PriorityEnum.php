<?php

namespace Tests\App\Enums;

enum PriorityEnum: int
{
    case LOWEST = 1;
    case LOW = 2;
    case MEDIUM = 3;
    case HIGH = 4;
    case HIGHEST = 5;

    public function label(): string
    {
        return self::getLabel($this->value);
    }

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::LOWEST->value => __('priorities.lowest'),
            self::LOW->value => __('priorities.low'),
            self::MEDIUM->value => __('priorities.medium'),
            self::HIGH->value => __('priorities.high'),
            self::HIGHEST->value => __('priorities.highest'),
        };
    }

    public static function getColor(int $value): string
    {
        return match ($value) {
            self::LOWEST->value => '#6772E5',
            self::LOW->value => '#A6B5BD',
            self::MEDIUM->value => '#20AEE3',
            self::HIGH->value => '#FF9041',
            self::HIGHEST->value => '#ff5C6C',
        };
    }

    public static function all(): array
    {
        return [
            [
                'id' => self::HIGHEST,
                'name' => self::HIGHEST->label(),
                'color' => self::getColor(self::HIGHEST->value),
            ],
            [
                'id' => self::HIGH,
                'name' => self::HIGH->label(),
                'color' => self::getColor(self::HIGH->value),
            ],
            [
                'id' => self::MEDIUM,
                'name' => self::MEDIUM->label(),
                'color' => self::getColor(self::MEDIUM->value),
            ],
            [
                'id' => self::LOW,
                'name' => self::LOW->label(),
                'color' => self::getColor(self::LOW->value),
            ],
            [
                'id' => self::LOWEST,
                'name' => self::LOWEST->label(),
                'color' => self::getColor(self::LOWEST->value),
            ],
        ];
    }

    public static function frontend(): array
    {
        return [
            'highest' => [
                'id' => self::HIGHEST->value,
                'name' => self::HIGHEST->label(),
                'color' => self::getColor(self::HIGHEST->value),
            ],
            'high' => [
                'id' => self::HIGH->value,
                'name' => self::HIGH->label(),
                'color' => self::getColor(self::HIGH->value),
            ],
            'medium' => [
                'id' => self::MEDIUM->value,
                'name' => self::MEDIUM->label(),
                'color' => self::getColor(self::MEDIUM->value),
            ],
            'low' => [
                'id' => self::LOW->value,
                'name' => self::LOW->label(),
                'color' => self::getColor(self::LOW->value),
            ],
            'lowest' => [
                'id' => self::LOWEST->value,
                'name' => self::LOWEST->label(),
                'color' => self::getColor(self::LOWEST->value),
            ],
        ];
    }
}
