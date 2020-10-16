<?php

namespace LaravelEnso\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Helpers\Traits\FiltersRequest;
use LaravelEnso\Products\Models\Product;

class ValidateProductRequest extends FormRequest
{
    use FiltersRequest;

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
            'suppliers.*.id' => 'numeric|exists:companies,id',
            'suppliers.*.pivot.part_number' => 'required|string',
            'suppliers.*.pivot.acquisition_price' => 'required|numeric|min:0.01',
            'defaultSupplierId' => 'nullable|numeric|exists:companies,id|required_with:suppliers',
            'name' => 'required|string|max:255',
            'part_number' => 'required|string',
            'internal_code' => ['nullable', 'string', 'max:255', $this->internalCodeUnique()],
            'measurement_unit_id' => 'required|exists:measurement_units,id',
            'packaging_unit_id' => 'required|exists:packaging_units,id',
            'package_quantity' => 'nullable|integer',
            'list_price' => 'required|numeric|min:0.01',
            'vat_percent' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'html_description' => 'nullable|string',
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

        if ($this->invalidSuppliers($suppliers)) {
            $this->validator->errors()->add('suppliers', __(
                'Part number and acquisition price are mandatory for each supplier'
            ));
        }

        $this->checkDefaultSupplier($suppliers);
    }

    protected function product()
    {
        return Product::where('part_number', $this->get('part_number'))
            ->where('manufacturer_id', $this->get('manufacturer_id'))
            ->where('id', '<>', optional($this->route('product'))->id);
    }

    protected function checkDefaultSupplier($suppliers)
    {
        if (! $suppliers->pluck('id')->contains($this->get('defaultSupplierId'))) {
            $this->validator->errors()->add('defaultSupplierId', __(
                'This supplier must be within selected suppliers'
            ));
        }

        if ($this->defaultAcquisitionPrice() > $this->get('list_price')) {
            Collection::wrap(['list_price', 'defaultSupplierId'])
                ->each(fn ($attribute) => $this->validator->errors()
                    ->add($attribute, __('The acquisition price is higher than the list price!')));
        }
    }

    protected function defaultAcquisitionPrice()
    {
        $defaultSupplier = Collection::wrap($this->get('suppliers'))
            ->first(fn ($supplier) => $supplier['id'] === $this->get('defaultSupplierId'));

        return $defaultSupplier['pivot']['acquisition_price'] ?? null;
    }

    protected function ensureNotParent()
    {
        if (Category::find($this->get('category_id'))->isParent()) {
            $this->validator->errors()->add(
                'category_id',
                __('Must choose a subcategory')
            );
        }
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

    private function internalCodeUnique()
    {
        return Rule::unique('products', 'internal_code')
            ->ignore(optional($this->route('product'))->id);
    }
}
