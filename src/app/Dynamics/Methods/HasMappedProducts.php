<?php

namespace LaravelEnso\Products\App\Dynamics\Methods;

use Closure;
use LaravelEnso\DynamicMethods\App\Contracts\Method;

class HasMappedProducts implements Method
{
    public function name(): string
    {
        return 'hasMappedProducts';
    }

    public function closure(): Closure
    {
        return fn () => $this->products()->exists();
    }
}
