<?php

namespace LaravelEnso\Products;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Products\App\Models\Picture;
use LaravelEnso\Products\App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load()
            ->publish()
            ->mapMorphs();
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
        ], ['products-factories', 'enso-factories']);

        $this->publishes([
            __DIR__.'/resources/images' => resource_path('images'),
        ], ['products-assets', 'enso-assets']);

        return $this;
    }

    private function mapMorphs()
    {
        Relation::morphMap([
            'product' => Product::class,
            'productPicture' => Picture::class,
        ]);

        return $this;
    }
}
