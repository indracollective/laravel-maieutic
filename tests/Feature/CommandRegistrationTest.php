<?php

declare(strict_types=1);

it('registers the maieutic command', function () {
    $this->artisan('list')
        ->expectsOutputToContain('maieutic')
        ->assertExitCode(0);
});

it('can display maieutic command help', function () {
    $this->artisan('maieutic --help')
        ->expectsOutputToContain('Interactive artisan command discovery through guided prompts')
        ->assertExitCode(0);
});

it('maieutic command has correct signature', function () {
    $kernel = $this->app->make('Illuminate\Contracts\Console\Kernel');
    $commands = $kernel->all();

    expect($commands)->toHaveKey('maieutic')
        ->and($commands['maieutic']->getName())->toBe('maieutic')
        ->and($commands['maieutic']->getDescription())->toBe('Interactive artisan command discovery through guided prompts');
});
