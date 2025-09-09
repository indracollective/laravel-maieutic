<?php

declare(strict_types=1);

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('commands extend the correct base class')
    ->expect('IndraCollective\LaravelMaieutic\Commands')
    ->toExtend('Illuminate\Console\Command');

arch('commands use strict types')
    ->expect('IndraCollective\LaravelMaieutic')
    ->toUseStrictTypes();

arch('commands have proper naming')
    ->expect('IndraCollective\LaravelMaieutic\Commands')
    ->toHaveSuffix('Command');
