<?php

declare(strict_types=1);

use IndraCollective\LaravelMaieutic\Commands\MaieuticCommand;
use IndraCollective\LaravelMaieutic\LaravelMaieuticServiceProvider;

it('registers the service provider', function () {
    $providers = $this->app->getLoadedProviders();

    expect($providers)->toHaveKey(LaravelMaieuticServiceProvider::class);
});

it('can resolve the maieutic command from container', function () {
    $command = $this->app->make(MaieuticCommand::class);

    expect($command)->toBeInstanceOf(MaieuticCommand::class);
});

it('command is available in artisan kernel', function () {
    $kernel = $this->app->make('Illuminate\Contracts\Console\Kernel');
    $commands = $kernel->all();

    expect($commands)->toHaveKey('?');
});
