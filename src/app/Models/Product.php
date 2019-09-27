<?php

namespace LaravelEnso\Products\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use LaravelEnso\Comments\app\Traits\Commentable;
use LaravelEnso\Documents\app\Traits\Documentable;
use LaravelEnso\Helpers\app\Traits\CascadesMorphMap;
use LaravelEnso\Helpers\app\Traits\InCents;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\Tables\app\Traits\TableCache;
use LaravelEnso\Helpers\app\Traits\ActiveState;
use LaravelEnso\DynamicMethods\app\Traits\Relations;
use LaravelEnso\Rememberable\app\Traits\Rememberable;
use LaravelEnso\Helpers\app\Traits\AvoidsDeletionConflicts;

class Product extends Model
{
    use ActiveState, AvoidsDeletionConflicts, InCents,
        Relations, Rememberable, TableCache,
        Documentable, Commentable, CascadesMorphMap;

    protected $fillable = [
        'manufacturer_id', 'name', 'part_number', 'internal_code', 'measurement_unit',
        'package_quantity', 'list_price', 'vat_percent', 'description', 'link', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    protected $centAttributes = ['list_price'];

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
        )->withPivot(['acquisition_price', 'is_default']);
    }

    public function defaultSupplier()
    {
        return $this->suppliers->first(function ($supplier) {
            return $supplier->pivot->is_default;
        });
    }

    public function syncSuppliers($supplierIds, $defaultSupplierId)
    {
        $pivotIds = collect($supplierIds)
            ->reduce(function ($pivot, $value) use ($defaultSupplierId) {
                return $pivot->put($value, ['is_default' => $value === $defaultSupplierId]);
            }, collect())->toArray();

        $this->suppliers()->sync($pivotIds);
    }
}
