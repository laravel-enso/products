<?php

namespace LaravelEnso\Products\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\app\Traits\ActiveState;
use LaravelEnso\Helpers\app\Traits\AvoidsDeletionConflicts;

class MeasurementUnit extends Model
{
    use ActiveState, AvoidsDeletionConflicts;

    protected $fillable = [
        'name', 'order_index', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
