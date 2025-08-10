<?php

namespace Marcionunes\PenumType\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ReflectionEnum;
use ReflectionMethod;
use SplFileInfo;

class CommandTypeScriptGenerator extends Command
{
    protected $signature = 'penum-type:generate';
    protected $description = 'Generate a .d.ts file for enums with a custom method.';

    public function handle()
    {
        $enumsPath = config('penum-type.path');
        $outputPath = config('penum-type.output');
        $dtsPath = $outputPath . '/enums.d.ts';

        $exportMethod = config('penum-type.enum_method_to_export');

        if (! File::exists($enumsPath)) {
            $this->warn("Enum path does not exist: $enumsPath");
            return;
        }

        File::ensureDirectoryExists($outputPath);

        $interfaces = [];

        foreach (File::allFiles($enumsPath) as $file) {
            /** @var SplFileInfo $file */
            $className = $this->getFullClassName($file);

            // Skip non-enums
            if (! enum_exists($className)) {
                continue;
            }

            $enum = new ReflectionEnum($className);

            // Check if frontend() method exists
            if (! $enum->hasMethod('frontend')) {
                continue;
            }

            $method = $enum->getMethod($exportMethod);

            // Must be public static
            if (! $method->isStatic() || !$method->isPublic()) {
                continue;
            }

            // Get the array returned by frontend()
            /** @var array $frontendData */
            $frontendData = $className::frontend();

            $enumName = $enum->getShortName();
            $interfaces[] = $this->generateInterface($enumName, $frontendData);

            $this->info("Included from frontend(): $enumName");
        }

        // Join all interfaces
        $dtsOutput = implode("\n\n", $interfaces);
        File::put($dtsPath, $dtsOutput);

        $this->info('✅ Generated .d.ts with frontend() enums:');
        $this->info("- $dtsPath");
    }

    protected function generateInterface(string $enumName, array $data): string
    {
        if (empty($data)) {
            return "export interface {$enumName} {}";
        }

        $firstValue = reset($data);

        // Case 1: Objects
        if (is_array($firstValue)) {
            $lines = ["export interface {$enumName} {"];

            foreach ($data as $key => $obj) {
                if (!is_array($obj)) {
                    continue; // skip invalid shapes
                }

                $fields = [];
                foreach ($obj as $fieldName => $fieldValue) {
                    $tsType = match (true) {
                        is_int($fieldValue) => 'number',
                        is_string($fieldValue) => 'string',
                        is_bool($fieldValue) => 'boolean',
                        default => 'any'
                    };
                    $fields[] = "    {$fieldName}: {$tsType}";
                }

                // Nest each key's object shape
                $lines[] = "  {$key}: {";
                $lines[] = implode("\n", $fields);
                $lines[] = "  }";
            }

            $lines[] = "}";
            return implode("\n", $lines);
        }

        // Case 2: Scalars
        $lines = ["export interface {$enumName} {"];
        foreach ($data as $key => $value) {
            $tsType = match (true) {
                is_int($value) => 'number',
                is_string($value) => 'string',
                is_bool($value) => 'boolean',
                default => 'any'
            };
            $lines[] = "  {$key}: {$tsType}";
        }
        $lines[] = "}";
        return implode("\n", $lines);
    }


    protected function getFullClassName(SplFileInfo $file): string
    {
        $content = File::get($file->getRealPath());
        preg_match('/namespace\s+([^;]+);/', $content, $matches);
        $namespace = $matches[1] ?? null;
        $class = $file->getBasename('.php');
        return $namespace ? "$namespace\\$class" : $class;
    }
}
