<?php

namespace LaravelEnso\Products\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Products\app\Enums\MeasurementUnits;

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
            'name' => 'required|string|max:75',
            'part_number' => 'required|integer',
            'internal_code' => 'nullable|string|max:100',
            'measurement_unit' => ['required', 'integer', $this->measurementExists()],
            'package_quantity' => 'nullable|integer',
            'list_price' => 'required|integer',
            'vat_percent' => 'nullable|integer',
            'description' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    private function measurementExists()
    {
        return Rule::in(MeasurementUnits::keys());
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->productExists()) {
                $validator->errors()->add('part_number', 'A product with the specified part number and made by the selected manufacturer already exists!');
                $validator->errors()->add('manufacturer_id', 'A product with the specified part number and made by the selected manufacturer already exists!');
            }
        });
    }

    private function productExists()
    {
        return Product::where('part_number', $this->get('part_number'))
            ->where('manufacturer_id', $this->get('manufacturer_id'))
            ->exists();
    }
}
