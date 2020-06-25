<?php

namespace LaravelEnso\Products\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use LaravelEnso\Companies\Models\Company;

class ProductSupplier extends Pivot
{
    protected $guarded = ['product_id', 'supplier_id'];

    protected $casts = ['is_default' => 'boolean'];

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
