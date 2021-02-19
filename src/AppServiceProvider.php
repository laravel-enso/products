<?php

namespace LaravelEnso\Products;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Products\Models\Picture;
use LaravelEnso\Products\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load()
            ->publish()
            ->mapMorphings();
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->mergeConfigFrom(__DIR__.'/../config/products.php', 'enso.products');

        return $this;
    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/../config' => config_path('enso'),
        ], ['products-config', 'enso-config']);

        $this->publishes([
            __DIR__.'/../database/factories' => database_path('factories'),
        ], ['products-factories', 'enso-factories']);

        $this->publishes([
            __DIR__.'/../resources/images' => resource_path('images'),
        ], ['products-assets', 'enso-assets']);

        return $this;
    }

    private function mapMorphings()
    {
        Product::morphMap();
        Picture::morphMap();

        return $this;
    }
}
