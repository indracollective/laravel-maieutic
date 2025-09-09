<?php

declare(strict_types=1);

it('registers the m command', function () {
    $this->artisan('list')
        ->expectsOutputToContain('m')
        ->assertExitCode(0);
});

it('can display m command help', function () {
    $this->artisan('m --help')
        ->expectsOutputToContain('Interactive artisan command discovery through guided prompts')
        ->assertExitCode(0);
});

it('m command has correct signature', function () {
    $kernel = $this->app->make('Illuminate\Contracts\Console\Kernel');
    $commands = $kernel->all();

    expect($commands)->toHaveKey('m')
        ->and($commands['m']->getName())->toBe('m')
        ->and($commands['m']->getDescription())->toBe('Interactive artisan command discovery through guided prompts');
});
