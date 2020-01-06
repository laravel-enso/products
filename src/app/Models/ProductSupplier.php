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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->inCents = true;
    }

    public static function boot()
    {
        self::saving(function ($model) {
            $model->inCents = false;
        });

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
