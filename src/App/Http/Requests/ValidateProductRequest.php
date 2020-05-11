<?php

namespace LaravelEnso\Products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use LaravelEnso\Categories\App\Models\Category;
use LaravelEnso\Products\App\Models\Product;

class ValidateProductRequest extends FormRequest
{
    protected $validator;
    protected $suppliers;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'nullable|integer|exists:categories,id',
            'manufacturer_id' => 'nullable|integer|exists:companies,id',
            'suppliers' => 'array',
            'suppliers.id' => 'nullable|numeric|exists:companies,id',
            'defaultSupplierId' => 'nullable|numeric|exists:companies,id|required_with:suppliers',
            'name' => 'required|string|max:255',
            'part_number' => 'required|string',
            'internal_code' => ['nullable', 'string', 'max:255', $this->internalCodeUnique()],
            'measurement_unit_id' => 'required|exists:measurement_units,id',
            'package_quantity' => 'nullable|integer',
            'list_price' => 'required|numeric|min:0.01',
            'vat_percent' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validator = $validator;
            $this->validateUniqueness();

            if ($this->filled('suppliers')) {
                $this->checkSuppliers();
            }

            if ($this->filled('category_id')) {
                $this->ensureNotParent();
            }
        });
    }

    protected function validateUniqueness()
    {
        if (! $this->product()->exists()) {
            return;
        }

        (new Collection(['part_number', 'manufacturer_id']))
            ->each(fn ($attribute) => $this->validator->errors()->add(
                $attribute,
                __('A product with the specified part number and manufacturer already exists')
            ));
    }

    protected function checkSuppliers()
    {
        $suppliers = new Collection($this->get('suppliers'));

        if ($suppliers->isNotEmpty() && ! $suppliers->pluck('id')->contains($this->get('defaultSupplierId'))) {
            $this->validator->errors()->add('defaultSupplierId', __(
                'This supplier must be within selected suppliers'
            ));
        }

        if ($this->invalidSuppliers($suppliers)) {
            $this->validator->errors()->add('suppliers', __(
                'Part number and acquisition price are mandatory for each supplier'
            ));
        }

        if ($this->filled('defaultSupplierId') && $this->invalidDefaultSupplier($suppliers)) {
            $this->validator->errors()->add('defaultSupplierId', __(
                'The default supplier does not have the minimum acquisition price'
            ));
        }
    }

    protected function product()
    {
        return Product::where('part_number', $this->get('part_number'))
            ->where('manufacturer_id', $this->get('manufacturer_id'))
            ->where('id', '<>', optional($this->route('product'))->id);
    }

    private function invalidSuppliers($suppliers)
    {
        return $suppliers->some(fn ($supplier) => $this->invalidSupplier($supplier));
    }

    private function invalidSupplier($supplier)
    {
        return ! is_numeric($supplier['pivot']['acquisition_price'])
            || $supplier['pivot']['acquisition_price'] <= 0
            || ! $supplier['pivot']['part_number'];
    }

    private function invalidDefaultSupplier(Collection $suppliers)
    {
        $defaultSupplier = $suppliers
            ->first(fn ($supplier) => $supplier['id'] === $this->get('defaultSupplierId'));

        return $suppliers
            ->reject(fn ($supplier) => $supplier['id'] === $defaultSupplier['id'])
            ->contains(fn ($supplier) => $supplier['pivot']['acquisition_price']
                < $defaultSupplier['pivot']['acquisition_price']);
    }

    private function internalCodeUnique()
    {
        return Rule::unique('products', 'internal_code')
            ->ignore(optional($this->route('product'))->id);
    }

    private function ensureNotParent()
    {
        if(Category::find($this->get('category_id'))->isParent()) {
            $this->validator->errors()->add(
                'category_id',
                __('Must choose a subcategory')
            );
        }
    }
}
