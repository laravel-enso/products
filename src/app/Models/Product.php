<?php

namespace LaravelEnso\Products\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\Helpers\app\Traits\ActiveState;
use LaravelEnso\Helpers\app\Traits\AvoidsDeletionConflicts;

class Product extends Model
{
    use ActiveState, AvoidsDeletionConflicts;

    protected $fillable = [
        'manufacturer_id', 'measurement_unit_id', 'name', 'part_number', 'internal_code',
        'list_price', 'vat_percent', 'package_quantity', 'description', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function measurementUnit()
    {
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Company::class, 'manufacturer_id');
    }

    public function suppliers()
    {
        return $this->belongsToMany(
            Company::class,
            'product_supplier',
            'product_id',
            'supplier_id'
        )->withPivot(['acquisiton_price', 'is_default']);
    }

    public function defaultSupplier()
    {
        return $this->suppliers()
            ->withPivot('acquisition_price')
            ->wherePivot('is_default', true)
            ->first();
    }
}
