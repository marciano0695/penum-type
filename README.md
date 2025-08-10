# Laravel Enum to TypeScript Types

This package automatically generates **TypeScript type definitions** (`.d.ts` files) from your Laravel enums, so you can keep backend and frontend in perfect sync without manually duplicating definitions.

---

## Example

### PHP Enums

**MessageTypeEnum**

```php
<?php

namespace Tests\App\Enums;

enum MessageTypeEnum: string
{
    case SUCCESS = 'success';
    case INFO = 'info';
    case ALERT = 'alert';
    case DANGER = 'danger';
    case STATUS = 'status';

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
```

**PriorityEnum**

```php
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
        return match ($this) {
            self::LOWEST => __('priorities.lowest'),
            self::LOW => __('priorities.low'),
            self::MEDIUM => __('priorities.medium'),
            self::HIGH => __('priorities.high'),
            self::HIGHEST => __('priorities.highest'),
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
```

---

### Generated `.d.ts` Output

```ts
export interface MessageTypeEnum {
	success: string
	info: string
	alert: string
	danger: string
	status: string
}

export interface PriorityEnum {
	highest: { id: number; name: string; color: string }
	high: { id: number; name: string; color: string }
	medium: { id: number; name: string; color: string }
	low: { id: number; name: string; color: string }
	lowest: { id: number; name: string; color: string }
}
```

### Ineriajs HandleInertiaRequests ($page.props)

```php
'constants' => [
    'flash' => MessageTypeEnum::frontend(),
    'status' => StatusEnum::frontend(),
    'roles' => UserRoleEnum::frontend(),
    'priorities' => PriorityEnum::frontend(),
    'planTypes' => PlanTypeEnum::frontend(),
    'periodicities' => PeriodicityEnum::frontend(),
    'qrTypes' => QRCodeTypeEnum::frontend(),
    'measurementUnitsTypes' => MeasurementTypeEnum::frontend(),
    'extraFieldsTypes' => ExtraFieldTypeEnum::frontend(),
    'criteriasTypes' => CriteriaTypeEnum::frontend(),
],
```

---

## Installation

Require the package via Composer:

```bash
composer require marcionunes/penum-type
```

Change config file to your needs

---

## Generating the TypeScript file

```bash
php artisan penum-type:generate
```

This will generate a `enums.d.ts` file at the configured output path.

---

## Auto-generate on changes

You can automatically regenerate `.d.ts` files when your enums change by adding a Vite watcher.

### 1. Install the watcher plugin

```bash
npm install --save-dev vite-plugin-watch-and-run
```

### 2. Update `vite.config.js`

```js
import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"
import { watchAndRun } from "vite-plugin-watch-and-run"
import { execSync } from "child_process"

let enumPath = "app/Enums"
try {
	enumPath = execSync("php artisan penum-type:path").toString().trim()
} catch (e) {
	console.warn("[penum-type] Could not determine enum path:", e.message)
}

export default defineConfig({
	plugins: [
		laravel({
			input: ["resources/css/app.css", "resources/js/app.js"],
			refresh: true,
		}),
		watchAndRun([
			{
				name: "watch-enums",
				watch: `${enumPath}/**/*.php`,
				run: "php artisan penum-type:generate",
			},
		]),
	],
})
```

---

## Example workflow

When you change `app/Enums/PriorityEnum.php`:

```bash
> php artisan penum-type:generate
> Enum generation complete.
```

---

## Benefits

- No more manual syncing between backend and frontend enums
- Type-safe `$page.props.constants` in Inertia.js
- Automatic regeneration on enum changes
