<?php

declare(strict_types=1);

it('registers the ? command', function () {
    $this->artisan('list')
        ->expectsOutputToContain('?')
        ->assertExitCode(0);
});

it('can display ? command help', function () {
    $this->artisan('? --help')
        ->expectsOutputToContain('Interactive artisan command discovery through guided prompts')
        ->assertExitCode(0);
});

it('? command has correct signature', function () {
    $kernel = $this->app->make('Illuminate\Contracts\Console\Kernel');
    $commands = $kernel->all();

    expect($commands)->toHaveKey('?')
        ->and($commands['?']->getName())->toBe('?')
        ->and($commands['?']->getDescription())->toBe('Interactive artisan command discovery through guided prompts');
});
