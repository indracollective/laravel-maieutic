<?php

namespace Indra\LaravelMaieutic\Commands;

use Illuminate\Console\Command;

class LaravelMaieuticCommand extends Command
{
    public $signature = 'laravel-maieutic';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
