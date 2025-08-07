<?php

namespace Marcionunes\PenumType;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use ReflectionEnum;
use SplFileInfo;

class CommandTypeScriptGenerator extends Command
{
    protected $signature = 'penum-type:generate';

    protected $description = 'Generate a TypeScript file for all enums.';

    public function handle(Filesystem $filesystem)
    {
        $enumsPath = config('penum-type.path');
        $outputPath = config('penum-type.output');

        $tsPath = $outputPath.'/index.ts';
        $dtsPath = $outputPath.'/index.d.ts';

        if (! File::exists($enumsPath)) {
            $this->warn("Enum path does not exist: $enumsPath");

            return;
        }

        File::ensureDirectoryExists($outputPath);

        $tsEnumDefs = '';
        $tsExports = '';
        $tsTypeExports = '';

        $dtsEnumDefs = '';

        $files = File::allFiles($enumsPath);

        /**
         * @var SplFileInfo $file
         */
        foreach ($files as $file) {

            $className = $this->getFullClassName($file);

            $enum = new ReflectionEnum($className);

            $enumName = $enum->getShortName();
            $cases = $enum->getCases();

            // Generate .ts content
            $tsEnumDefs .= "const $enumName = {\n";
            $dtsEnumDefs .= "export enum $enumName {\n";

            foreach ($cases as $case) {
                $name = $case->getName();
                $value = $case->getValue()->value;

                $tsEnumDefs .= "  $name: '$value',\n";
                $dtsEnumDefs .= "  $name = '$value',\n";
            }

            $tsEnumDefs .= "} as const;\n\n";
            $tsEnumDefs .= "type $enumName = (typeof $enumName)[keyof typeof $enumName];\n\n";

            $dtsEnumDefs .= "}\n\n";

            $tsExports .= "$enumName, ";
            $tsTypeExports .= "$enumName as {$enumName}Type, ";

            $this->info("Included: $enumName");
        }

        // Final exports
        $tsEnumDefs .= "export { $tsExports };\n";
        $tsEnumDefs .= "export type { $tsTypeExports };";

        File::put($tsPath, trim($tsEnumDefs));
        File::put($dtsPath, trim($dtsEnumDefs));

        $this->info('✅ Generated grouped enums at:');
        $this->info("- $tsPath");
        $this->info("- $dtsPath");
    }

    protected function getFullClassName(SplFileInfo $file): string
    {
        $content = File::get($file->getRealPath());

        $namespace = null;
        if (preg_match('/namespace (.*);/', $content, $matches)) {
            $namespace = trim($matches[1]);
        }

        $class = $file->getBasename('.php');

        return $namespace ? "$namespace\\$class" : $class;
    }
}
