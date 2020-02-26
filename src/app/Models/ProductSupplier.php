<?php

namespace LaravelEnso\Products\App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use LaravelEnso\Companies\App\Models\Company;

class ProductSupplier extends Pivot
{
    protected $fillable = [
        'product_id', 'supplier_id', 'acquisition_price', 'part_number',
        'is_default', 'created_at', 'updated_at',
    ];

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
