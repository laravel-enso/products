<?php

namespace LaravelEnso\Products\app\Models;

use LaravelEnso\Helpers\app\Traits\InCents;
use LaravelEnso\Companies\app\Models\Company;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSupplier extends Pivot
{
    use InCents;

    protected $fillable = [
        'product_id', 'supplier_id', 'acquisition_price', 'part_number', 'is_default',
        'created_at', 'updated_at',
    ];

    protected $casts = ['is_default' => 'boolean'];

    protected $centAttributes = ['acquisition_price'];

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
