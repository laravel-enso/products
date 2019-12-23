<?php

namespace LaravelEnso\Products\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Comments\app\Traits\Commentable;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\Documents\app\Traits\Documentable;
use LaravelEnso\DynamicMethods\app\Traits\Relations;
use LaravelEnso\Helpers\app\Contracts\Activatable;
use LaravelEnso\Helpers\app\Traits\ActiveState;
use LaravelEnso\Helpers\app\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Helpers\app\Traits\CascadesMorphMap;
use LaravelEnso\Helpers\app\Traits\InCents;
use LaravelEnso\MeasurementUnits\app\Models\MeasurementUnit;
use LaravelEnso\Rememberable\app\Traits\Rememberable;
use LaravelEnso\Tables\app\Traits\TableCache;

class Product extends Model implements Activatable
{
    use ActiveState, AvoidsDeletionConflicts, CascadesMorphMap, Commentable,
        Documentable, InCents, Relations, Rememberable, TableCache;

    protected $fillable = [
        'manufacturer_id', 'measurement_unit_id', 'name', 'part_number', 'internal_code',
        'package_quantity', 'list_price', 'vat_percent', 'description', 'link', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    protected $centAttributes = ['list_price'];

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
            Company::class, 'product_supplier', 'product_id', 'supplier_id'
        )->using(ProductSupplier::class)
        ->withPivot(['part_number', 'acquisition_price', 'is_default'])
        ->withTimeStamps();
    }

    public function defaultSupplier()
    {
        return $this->suppliers
            ->first(fn($supplier) => $supplier->pivot->is_default);
    }

    public function syncSuppliers($suppliers, $defaultSupplierId)
    {
        $pivotIds = collect($suppliers)
            ->reduce(fn($pivot, $supplier) => (
                $pivot->put($supplier['id'], [
                    'part_number' => $supplier['pivot']['part_number'],
                    'acquisition_price' => $supplier['pivot']['acquisition_price'],
                    'is_default' => $supplier['id'] === $defaultSupplierId,
                ])
            ), collect())
            ->toArray();

        $this->suppliers()->sync($pivotIds);
    }
}
