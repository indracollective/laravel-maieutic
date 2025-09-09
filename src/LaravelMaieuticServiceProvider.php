<?php

declare(strict_types=1);

namespace IndraCollective\LaravelMaieutic;

use IndraCollective\LaravelMaieutic\Commands\MaieuticCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMaieuticServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-maieutic')
            ->hasCommand(MaieuticCommand::class);
    }
}
