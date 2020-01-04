<?php

namespace LaravelEnso\Products\App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use LaravelEnso\Companies\App\Models\Company;
use LaravelEnso\Helpers\App\Traits\InCents;

class ProductSupplier extends Pivot
{
    use InCents;

    protected $fillable = [
        'product_id', 'supplier_id', 'acquisition_price', 'part_number', 'is_default',
        'created_at', 'updated_at',
    ];

    protected $casts = ['is_default' => 'boolean'];

    protected $centAttributes = ['acquisition_price'];

    public static function boot()
    {
        self::saving(fn ($model) => $model->inCents = true);

        parent::boot();
    }

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
