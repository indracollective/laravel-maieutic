<?php

declare(strict_types=1);

use IndraCollective\ArtisanFind\Commands\ArtisanFindCommand;

it('can instantiate the command', function () {
    $command = new ArtisanFindCommand;
    expect($command)->toBeInstanceOf(ArtisanFindCommand::class);
});

it('find command is registered', function () {
    $this->artisan('list')
        ->expectsOutputToContain('find')
        ->assertExitCode(0);
});

it('find command shows help correctly', function () {
    $this->artisan('find --help')
        ->expectsOutputToContain('Interactive artisan command discovery through guided prompts')
        ->assertExitCode(0);
});

// Simple test to verify the command structure
it('has correct command signature', function () {
    $kernel = $this->app->make('Illuminate\Contracts\Console\Kernel');
    $commands = $kernel->all();

    expect($commands)->toHaveKey('find')
        ->and($commands['find']->getName())->toBe('find')
        ->and($commands['find']->getDescription())->toBe('Interactive artisan command discovery through guided prompts');
});
