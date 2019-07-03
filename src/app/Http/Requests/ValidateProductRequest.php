<?php

namespace LaravelEnso\Products\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'manufacturer_id' => 'required|integer|exists:companies,id',
            'measurement_unit_id' => 'required|integer|exists:measurement_units,id',
            'name' => 'required|string|max:75',
            'part_number' => 'required|integer',
            'internal_code' => 'nullable|string|max:100',
            'list_price'=> 'required|integer',
            'vat_percent' => 'nullable|integer',
            'package_quantity' => 'nullable|integer',
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ];
    }
}
