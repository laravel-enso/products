<?php

namespace LaravelEnso\Products\app\Console\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Products\app\Console\Commands\DatabaseUpgrades\ProductsUpgrade;

class Upgrade extends Command
{
    protected $signature = 'enso:products:upgrade {--enum= : Give an enum to use for seeding }';

    protected $description = 'This command will upgrade the products package';

    public function handle()
    {
        $this->upgrade();
    }

    private function upgrade()
    {
        $enum = $this->option('enum');

        (new ProductsUpgrade($enum))->handle();
    }
}
