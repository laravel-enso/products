<?php

namespace LaravelEnso\Products;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Products\app\Console\Commands\Upgrade;
use LaravelEnso\Products\app\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this
            ->addCommands()
            ->load()
            ->publish()
            ->mapMorphings();
    }

    private function addCommands()
    {
        $this->commands(
            Upgrade::class,
        );

        return $this;
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        return $this;
    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/database/factories' => database_path('factories'),
        ], 'products-factories');

        return $this;
    }

    private function mapMorphings()
    {
        Relation::morphMap([
            'product' => Product::class,
        ]);

        return $this;
    }
}
