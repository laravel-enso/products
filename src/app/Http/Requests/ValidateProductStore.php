<?php

namespace LaravelEnso\Products\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Products\app\Enums\MeasurementUnits;

class ValidateProductStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'manufacturer_id' => 'required|integer|exists:companies,id',
            'suppliers' => 'array',
            'suppliers.*' => 'exists:companies,id',
            'defaultSupplierId' => 'nullable|exists:companies,id|required_with:suppliers',
            'name' => 'required|string|max:75',
            'part_number' => 'required|integer',
            'internal_code' => 'nullable|string|max:100',
            'measurement_unit' => ['required', 'integer', $this->measurementUnits()],
            'package_quantity' => 'nullable|integer',
            'list_price' => 'required|numeric|min:0.01',
            'vat_percent' => 'required|integer',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    protected function measurementUnits()
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

            if (collect($this->get('suppliers'))->isNotEmpty()
                && ! collect($this->get('suppliers'))->contains($this->get('defaultSupplierId'))) {
                $validator->errors()->add('defaultSupplierId', 'This supplier must be within selected suppliers');
            }
        });
    }

    protected function productExists()
    {
        return $this->filled('manufacturer_id')
            && $this->productQuery()->exists();
    }

    protected function productQuery()
    {
        return Product::where('part_number', $this->get('part_number'))
            ->where('manufacturer_id', $this->get('manufacturer_id'));
    }
}
