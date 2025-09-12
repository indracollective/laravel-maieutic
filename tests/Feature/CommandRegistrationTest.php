<?php

declare(strict_types=1);

it('registers the find command', function () {
    $this->artisan('list')
        ->expectsOutputToContain('find')
        ->assertExitCode(0);
});

it('can display find command help', function () {
    $this->artisan('find --help')
        ->expectsOutputToContain('Interactive artisan command discovery through guided prompts')
        ->assertExitCode(0);
});

it('find command has correct signature', function () {
    $kernel = $this->app->make('Illuminate\Contracts\Console\Kernel');
    $commands = $kernel->all();

    expect($commands)->toHaveKey('find')
        ->and($commands['find']->getName())->toBe('find')
        ->and($commands['find']->getDescription())->toBe('Interactive artisan command discovery through guided prompts');
});
