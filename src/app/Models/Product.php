<?php

namespace LaravelEnso\Products\app\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'manufacturer_id', 'name', 'part_number', 'internal_code', 'list_price',
        'vat_percent', 'package_quantity', 'description', 'is_active',
    ];
}
