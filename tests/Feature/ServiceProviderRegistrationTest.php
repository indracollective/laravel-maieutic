<?php

declare(strict_types=1);

use IndraCollective\ArtisanFind\ArtisanFindServiceProvider;
use IndraCollective\ArtisanFind\Commands\ArtisanFindCommand;

it('registers the service provider', function () {
    $providers = $this->app->getLoadedProviders();

    expect($providers)->toHaveKey(ArtisanFindServiceProvider::class);
});

it('can resolve the find command from container', function () {
    $command = $this->app->make(ArtisanFindCommand::class);

    expect($command)->toBeInstanceOf(ArtisanFindCommand::class);
});

it('command is available in artisan kernel', function () {
    $kernel = $this->app->make('Illuminate\Contracts\Console\Kernel');
    $commands = $kernel->all();

    expect($commands)->toHaveKey('m');
});
