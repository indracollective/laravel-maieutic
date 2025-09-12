<?php

declare(strict_types=1);

namespace IndraCollective\ArtisanFind;

use IndraCollective\ArtisanFind\Commands\ArtisanFindCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ArtisanFindServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-artisan-find')
            ->hasCommand(ArtisanFindCommand::class);
    }
}
