<?php

namespace LaravelEnso\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use LaravelEnso\Categories\App\Models\Category;
use LaravelEnso\Comments\App\Traits\Commentable;
use LaravelEnso\Companies\App\Models\Company;
use LaravelEnso\Documents\App\Traits\Documentable;
use LaravelEnso\DynamicMethods\App\Traits\Relations;
use LaravelEnso\DynamicMethods\App\Traits\Scopes;
use LaravelEnso\Helpers\App\Contracts\Activatable;
use LaravelEnso\Helpers\App\Traits\ActiveState;
use LaravelEnso\Helpers\App\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Helpers\App\Traits\CascadesMorphMap;
use LaravelEnso\MeasurementUnits\App\Models\MeasurementUnit;
use LaravelEnso\Rememberable\App\Traits\Rememberable;
use LaravelEnso\Tables\App\Traits\TableCache;

class Product extends Model implements Activatable
{
    use ActiveState,
        AvoidsDeletionConflicts,
        CascadesMorphMap,
        Commentable,
        Documentable,
        Relations,
        Rememberable,
        Scopes,
        TableCache;

    protected $guarded = ['id'];

    protected $casts = ['is_active' => 'boolean'];

    public function picture()
    {
        return $this->hasOne(Picture::class)
            ->orderBy('order_index');
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class)
            ->orderBy('order_index');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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
        )->using(ProductSupplier::class)
            ->withPivot(['part_number', 'acquisition_price', 'is_default'])
            ->withTimeStamps();
    }

    public function defaultSupplier()
    {
        return $this->suppliers
            ->first(fn ($supplier) => $supplier->pivot->is_default);
    }

    public function pictureUrl()
    {
        return optional($this->picture)->url()
            ?? Picture::defaultUrl();
    }

    public function getPictureUrlAttribute()
    {
        return $this->pictureUrl();
    }

    public function syncSuppliers(array $suppliers, ?int $defaultSupplierId)
    {
        $pivot = (new Collection($suppliers))
            ->mapWithKeys(fn ($supplier) => [
                $supplier['id'] => [
                    'part_number' => $supplier['pivot']['part_number'],
                    'acquisition_price' => $supplier['pivot']['acquisition_price'],
                    'is_default' => $supplier['id'] === $defaultSupplierId,
                ],
            ]);

        $this->suppliers()->sync($pivot);
    }

    public function uploadPictures(array $pictures)
    {
        $lastIndex = (int) $this->pictures()->max('order_index');

        (new Collection($pictures))->values()
            ->each(fn ($picture, $index) => $this
                ->uploadPicture($picture, $lastIndex + $index + 1));
    }

    public function uploadPicture(UploadedFile $picture, int $orderIndex)
    {
        $this->pictures()
            ->create(['order_index' => $orderIndex])
            ->upload($picture);
    }
}
