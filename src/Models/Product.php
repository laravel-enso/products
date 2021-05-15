<?php

namespace LaravelEnso\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Comments\Traits\Commentable;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Documents\Traits\Documentable;
use LaravelEnso\DynamicMethods\Traits\Abilities;
use LaravelEnso\Helpers\Contracts\Activatable;
use LaravelEnso\Helpers\Traits\ActiveState;
use LaravelEnso\Helpers\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Helpers\Traits\CascadesMorphMap;
use LaravelEnso\MeasurementUnits\Models\MeasurementUnit;
use LaravelEnso\PackagingUnits\Models\PackagingUnit;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\Tables\Traits\TableCache;

class Product extends Model implements Activatable
{
    use Abilities, ActiveState, AvoidsDeletionConflicts, CascadesMorphMap;
    use Commentable, Documentable, HasFactory, Rememberable, TableCache;

    protected $guarded = ['id'];

    protected $casts = ['is_active' => 'boolean'];

    protected $rememberableKeys = ['id', 'internal_code'];

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

    public function packagingUnit()
    {
        return $this->belongsTo(PackagingUnit::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Company::class);
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

    public function acquisitionPrice(Company $supplier)
    {
        $supplier = $this->suppliers()->firstWhere('id', $supplier->id)
            ?? $this->defaultSupplier();

        return $supplier
            ? $supplier->pivot->acquisition_price
            : $this->listPrice();
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
        $pivot = Collection::wrap($suppliers)
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
            ->file->upload($picture);
    }

    public function attachPicture(string $path, string $filename)
    {
        $orderIndex = $this->pictures()->max('order_index') + 1;

        $this->pictures()
            ->create(['order_index' => $orderIndex])
            ->file->attach($path, $filename);
    }

    public function internalCode(): string
    {
        $length = Config::get('enso.products.internalCode.length');

        return Config::get('enso.products.internalCode.prefix')
            .sprintf("%0{$length}d", $this->id);
    }

    protected function generateSlug(): string
    {
        return Str::slug($this->name);
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->fill(['slug' => $product->generateSlug()]);
        });

        static::updating(function ($product) {
            $product->fill(['slug' => $product->generateSlug()]);
        });

        $mode = Config::get('enso.products.internalCode.mode');

        if ($mode === 'auto') {
            static::created(function ($model) {
                $model::withoutEvents(fn () => $model
                    ->update(['internal_code' => $model->internalCode()]));
            });
        }
    }
}
