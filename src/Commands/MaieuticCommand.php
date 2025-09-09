<?php

declare(strict_types=1);

namespace IndraCollective\LaravelMaieutic\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class MaieuticCommand extends Command
{
    protected $signature = '?';

    protected $description = 'Interactive artisan command discovery through guided prompts';

    private Collection $commands;

    public function handle(): int
    {
        intro('Laravel Maieutic');

        $this->newLine();

        $this->loadCommands();

        while (true) {
            $grouping = $this->selectGrouping();
            if ($grouping === 'exit') {
                break;
            }

            $group = $this->selectGroup($grouping);
            if ($group === 'back') {
                continue;
            }

            $command = $this->selectCommand($group, $grouping);
            if (! $command) {
                continue;
            } // User went back

            $builtCommand = $this->buildCommand($command);

            if ($this->confirmExecution($builtCommand)) {
                $this->executeCommand($builtCommand);
                break;
            }
            // User declined execution, offer to try again
            if (! confirm('Would you like to select a different command?', true)) {
                break;
            }

        }

        outro('Thanks for using Laravel Maieutic!');

        return self::SUCCESS;
    }

    private function loadCommands(): void
    {
        $this->commands = collect($this->getApplication()->all())
            ->filter(fn ($cmd) => ! in_array($cmd->getName(), ['maieutic', 'completion', 'help', 'list']))
            ->map(function ($cmd) {
                return [
                    'name' => $cmd->getName(),
                    'description' => $cmd->getDescription(),
                    'definition' => $cmd->getDefinition(),
                    'namespace' => $this->extractNamespace($cmd->getName()),
                    'vendor' => $this->detectVendor($cmd),
                ];
            })
            ->values();
    }

    private function extractNamespace(string $commandName): string
    {
        if (str_contains($commandName, ':')) {
            return Str::before($commandName, ':');
        }

        return 'core';
    }

    private function detectVendor(object $command): string
    {
        $className = get_class($command);

        if (Str::startsWith($className, 'Illuminate\\')) {
            return 'laravel';
        }

        if (preg_match('/^([A-Z][a-zA-Z0-9]+\\\\[A-Z][a-zA-Z0-9]+)\\\\/', $className, $matches)) {
            $vendor = Str::lower(str_replace('\\', '/', $matches[1]));

            $knownVendors = [
                'livewire' => 'livewire',
                'filament' => 'filament',
                'spatie' => 'spatie',
                'laravel' => 'laravel',
                'pest' => 'pest',
            ];

            foreach ($knownVendors as $pattern => $name) {
                if (Str::contains($vendor, $pattern)) {
                    return $name;
                }
            }

            return Str::before($vendor, '/');
        }

        if (Str::startsWith($className, 'App\\')) {
            return 'app';
        }

        return 'unknown';
    }

    private function selectGrouping(): string
    {
        $namespaces = $this->commands->groupBy('namespace')->keys()->filter(fn ($ns) => $ns !== 'core');
        $vendors = $this->commands->groupBy('vendor')->keys();

        $groupingOptions = [];

        $groupingOptions['search'] = 'Search all commands directly';

        if ($namespaces->count() > 1) {
            $groupingOptions['namespace'] = "Browse by command type ({$namespaces->count()} types found)";
        }

        if ($vendors->count() > 2) {
            $groupingOptions['vendor'] = "Browse by vendor ({$vendors->count()} vendors found)";
        }

        if (count($groupingOptions) === 2) {
            return array_keys($groupingOptions)[1];
        }

        $groupingOptions['exit'] = 'Exit';

        return select(
            label: 'How would you like to find commands?',
            options: $groupingOptions,
            default: 'search'
        );
    }

    private function selectGroup(string $grouping): string
    {
        if ($grouping === 'search') {
            return 'all';
        }

        $groups = $this->commands->groupBy($grouping)->keys()->sort();

        $groupOptions = $groups->mapWithKeys(function ($group) use ($grouping) {
            $count = $this->commands->where($grouping, $group)->count();

            return [$group => "{$group} ({$count} commands)"];
        });

        $groupOptions->put('back', '← Back');

        return select(
            label: "Select a {$grouping}:",
            options: $groupOptions->all(),
            scroll: 15
        );
    }

    private function selectCommand(string $group, string $grouping): ?array
    {
        $groupCommands = $group === 'all'
            ? $this->commands
            : $this->commands->where($grouping, $group);

        $commandOptions = $groupCommands->mapWithKeys(fn ($cmd) => [
            $cmd['name'] => "{$cmd['name']} - {$cmd['description']}",
        ]);

        $commandCount = $commandOptions->count();

        if ($group === 'all' || $commandCount > 15) {
            $commandName = search(
                label: $group === 'all' ? 'Search all commands:' : "Search {$group} commands:",
                placeholder: 'Type to search commands... (or press Ctrl+U to go back)',
                options: fn ($value) => $commandOptions
                    ->filter(fn ($desc, $name) => Str::contains($name, $value, ignoreCase: true) ||
                        Str::contains($desc, $value, ignoreCase: true)
                    )
                    ->sortKeys()
                    ->take(15)
                    ->all()
            );
        } else {
            $browseOptions = $commandOptions->sortKeys();
            $browseOptions->put('back', '← Back');

            $commandName = select(
                label: "Select a {$group} command:",
                options: $browseOptions->all(),
                scroll: 15
            );

            if ($commandName === 'back') {
                return null;
            }
        }

        return $this->commands->firstWhere('name', $commandName);
    }

    private function buildCommand(array $command): string
    {
        $builtCommand = "php artisan {$command['name']}";
        $definition = $command['definition'];

        $arguments = collect($definition->getArguments())
            ->filter(fn ($arg) => $arg->getName() !== 'command');

        if ($arguments->isNotEmpty()) {
            $this->info("\n📝 This command requires some arguments:");

            foreach ($arguments as $argument) {
                $value = $this->promptForArgument($argument);
                if ($value) {
                    $builtCommand .= " {$value}";
                }
            }
        }

        $options = collect($definition->getOptions())
            ->filter(fn ($opt) => ! in_array($opt->getName(), ['help', 'quiet', 'verbose', 'version', 'ansi', 'no-ansi', 'no-interaction', 'env']));

        if ($options->isNotEmpty()) {
            $selectedOptions = multiselect(
                label: 'Select any options you\'d like to include:',
                options: $options->mapWithKeys(fn ($opt) => [
                    $opt->getName() => "--{$opt->getName()}".
                        ($opt->getDescription() ? " ({$opt->getDescription()})" : ''),
                ])->all(),
                hint: 'Use space to select, enter to continue'
            );

            foreach ($selectedOptions as $optionName) {
                $option = $options->first(fn ($opt) => $opt->getName() === $optionName);

                if ($option && $option->acceptValue()) {
                    $defaultValue = $option->getDefault();
                    $defaultString = is_array($defaultValue)
                        ? implode(',', $defaultValue)
                        : (string) $defaultValue;

                    $value = text(
                        label: "Value for --{$optionName}:",
                        placeholder: $option->getDescription() ?: 'Enter value...',
                        default: $defaultString
                    );
                    $builtCommand .= " --{$optionName}={$value}";
                } else {
                    $builtCommand .= " --{$optionName}";
                }
            }
        }

        return $builtCommand;
    }

    private function promptForArgument($argument): string
    {
        $isRequired = $argument->isRequired();
        $description = $argument->getDescription() ?: $argument->getName();

        return text(
            label: ($isRequired ? '* ' : '').Str::title($description).':',
            placeholder: "Enter {$argument->getName()}...",
            required: $isRequired,
            default: $argument->getDefault()
        );
    }

    private function confirmExecution(string $command): bool
    {
        $this->newLine();
        $this->info('📋 Command Preview:');
        $this->line("   <fg=cyan>{$command}</>");
        $this->newLine();

        return confirm(
            label: 'Execute this command?',
            default: true,
            hint: 'This will run the command above'
        );
    }

    private function executeCommand(string $command): void
    {
        $this->info('🚀 Executing command...');
        $this->newLine();

        $commandParts = explode(' ', Str::after($command, 'php artisan '));
        $commandName = array_shift($commandParts);

        $arguments = [];
        $options = [];

        foreach ($commandParts as $part) {
            if (Str::startsWith($part, '--')) {
                [$key, $value] = explode('=', $part.'=', 2);
                $options[Str::after($key, '--')] = $value ?: true;
            } else {
                $arguments[] = $part;
            }
        }

        $parameters = array_merge(['command' => $commandName], $arguments, $options);

        $exitCode = $this->call($commandName, $parameters);

        $this->newLine();
        if ($exitCode === 0) {
            $this->info('✅ Command executed successfully!');
        } else {
            $this->error("❌ Command failed with exit code: {$exitCode}");
        }
    }
}
