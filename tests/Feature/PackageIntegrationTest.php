<?php

declare(strict_types=1);

it('loads without errors', function () {
    expect(true)->toBeTrue();
});

it('has correct package name in composer', function () {
    $composerPath = __DIR__.'/../../composer.json';
    $composer = json_decode(file_get_contents($composerPath), true);

    expect($composer['name'])->toBe('indracollective/laravel-maieutic');
});

it('has correct namespace in composer autoload', function () {
    $composerPath = __DIR__.'/../../composer.json';
    $composer = json_decode(file_get_contents($composerPath), true);

    expect($composer['autoload']['psr-4'])->toHaveKey('IndraCollective\\LaravelMaieutic\\');
});

it('has pest configured correctly', function () {
    $composerPath = __DIR__.'/../../composer.json';
    $composer = json_decode(file_get_contents($composerPath), true);

    expect($composer['require-dev'])->toHaveKey('pestphp/pest')
        ->and($composer['require-dev'])->toHaveKey('pestphp/pest-plugin-laravel')
        ->and($composer['scripts']['test'])->toBe('vendor/bin/pest');
});
