<?php

namespace Tests\App\Enums;

enum MessageTypeEnum: string
{
    case SUCCESS = 'success';
    case INFO = 'info';
    case ALERT = 'alert';
    case DANGER = 'danger';
    case STATUS = 'status';

    public static function getMessages(Request $request): array
    {
        return [
            self::SUCCESS->value => fn() => $request->session()->get(self::SUCCESS->value),
            self::INFO->value => fn() => $request->session()->get(self::INFO->value),
            self::ALERT->value => fn() => $request->session()->get(self::ALERT->value),
            self::DANGER->value => fn() => $request->session()->get(self::DANGER->value),
            self::STATUS->value => fn() => $request->session()->get(self::STATUS->value),
        ];
    }

    public static function frontend(): array
    {
        return [
            self::SUCCESS->value => self::SUCCESS->value,
            self::INFO->value => self::INFO->value,
            self::ALERT->value => self::ALERT->value,
            self::DANGER->value => self::DANGER->value,
            self::STATUS->value => self::STATUS->value,
        ];
    }
}
