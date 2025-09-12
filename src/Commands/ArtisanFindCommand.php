<?php

declare(strict_types=1);

namespace IndraCollective\ArtisanFind\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

class ArtisanFindCommand extends Command
{
    protected $signature = 'find {search? : Prefill search with this term}';

    protected $description = 'Interactive artisan command discovery through guided prompts';

    private Collection $commands;

    public function handle(): int
    {
        intro('Artisan Find 🔍');

        $this->newLine();

        $this->loadCommands();

        while (true) {
            $command = $this->selectCommandWithSuggest();
            if (! $command) {
                break;
            }

            $builtCommand = $this->buildCommand($command);

            if ($this->confirmAndCopy($builtCommand)) {
                break;
            }

            if (! confirm('Would you like to select a different command?', true)) {
                break;
            }
        }

        outro('Thanks for using Laravel Find!');

        return self::SUCCESS;
    }

    private function loadCommands(): void
    {
        $this->commands = collect($this->getApplication()->all())
            ->filter(fn ($cmd) => ! in_array($cmd->getName(), ['m', 'completion', 'help', 'list']))
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

    /**
     * Guide the user through discovery by presenting choices and awaiting their selection.
     * Through inquiry, we lead them to their own understanding.
     * What they seek reveals itself.
     */
    private function selectCommandWithSuggest(): ?array
    {
        $selectedOption = suggest(
            label: 'Find Artisan command',
            options: fn ($value) => $this->filterCommands($value),
            default: $this->argument('search') ?? '',
            placeholder: 'Type to search commands or use arrows to browse...',
            hint: 'Search by command name or description'
        );

        if (empty($selectedOption)) {
            return null;
        }

        // Extract command name from display string "command-name - Description"
        $commandName = Str::before($selectedOption, ' - ');

        return $this->commands->firstWhere('name', $commandName);
    }

    /**
     * Refine the realm of possibilities through the user's expressed intent.
     * Each character they offer narrows the path.
     * Discovery emerges.
     */
    private function filterCommands(string $value): array
    {
        if (empty($value)) {
            return $this->commands
                ->sortBy('name')
                ->take(500)
                ->mapWithKeys(fn ($cmd) => [
                    $cmd['name'] => "{$cmd['name']} - {$cmd['description']}",
                ])
                ->all();
        }

        return $this->commands
            ->filter(fn ($cmd) => Str::contains($cmd['name'], $value, ignoreCase: true) ||
                Str::contains($cmd['description'], $value, ignoreCase: true)
            )
            ->sortBy('name')
            ->take(500)
            ->mapWithKeys(fn ($cmd) => [
                $cmd['name'] => "{$cmd['name']} - {$cmd['description']}",
            ])
            ->all();
    }

    private function copyToClipboard(string $text): bool
    {
        $commands = [
            'pbcopy' => 'echo '.escapeshellarg($text).' | pbcopy',
            'xclip' => 'echo '.escapeshellarg($text).' | xclip -selection clipboard',
            'clip' => 'echo '.escapeshellarg($text).' | clip',
        ];

        foreach ($commands as $program => $command) {
            if (shell_exec("which $program 2>/dev/null")) {
                shell_exec($command);

                return true;
            }
        }

        return false;
    }

    /**
     * Construct understanding through careful questioning about requirements.
     * Each answer builds toward complete expression.
     * Intent becomes clear.
     */
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
        $default = $argument->getDefault();

        return text(
            label: ($isRequired ? '* ' : '').Str::title($description).':',
            placeholder: "Enter {$argument->getName()}...",
            required: $isRequired,
            default: $default ? (string) $default : ''
        );
    }

    /**
     * Present the culmination of our inquiry for final contemplation.
     * True understanding comes when one chooses to act.
     * Knowledge becomes action.
     */
    private function confirmAndCopy(string $command): bool
    {
        $this->newLine();
        $this->info('📋 Command Preview:');
        $this->line("   <fg=cyan>{$command}</>");
        $this->newLine();

        if (confirm(
            label: 'Copy this command to clipboard?',
            default: true,
            hint: 'This will copy the command above to your clipboard'
        )) {
            if ($this->copyToClipboard($command)) {
                $this->info('✅ Command copied to clipboard! You can now paste it in your terminal.');
            } else {
                $this->warn('⚠️  Could not copy to clipboard. Here\'s your command:');
                $this->line("   <fg=cyan>{$command}</>");
            }

            return true;
        }

        return false;
    }
}
