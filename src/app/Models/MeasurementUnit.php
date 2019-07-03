<?php

namespace LaravelEnso\Products\app\Models;

use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
    protected $fillable = [
        'name', 'order_index', 'is_active'
    ];

    public function usedFor()
    {
        return $this->hasMany(Product::class);
    }
}
