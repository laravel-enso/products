<?php

namespace LaravelEnso\Products\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Companies\app\Models\Company;

class Product extends Model
{
    protected $fillable = [
        'manufacturer_id', 'measurement_unit_id', 'name', 'part_number', 'internal_code', 
        'list_price', 'vat_percent', 'package_quantity', 'description', 'is_active',
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
            'product_supplier', 'product_id', 'supplier_id'
        );
    }
}
