<?php

namespace LaravelEnso\Products\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Discounts\Models\Suppliers\General;
use LaravelEnso\Helpers\Services\PriceComputor;
use LaravelEnso\Products\Models\Product;

class Supplier extends JsonResource
{
    protected ?Product $product;

    public function toArray($request)
    {
        $format = Config::get('enso.config.dateFormat');
        $params = json_decode($request->get('customParams'), true);
        $id = $params['product'] ?? $this->pivot?->product_id;

        $this->product = $id ? Product::find($id) : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'pivot' => [
                'partNumber' => $this->partNumber(),
                'acquisitionPrice' => $this->acquisitionPrice(),
                'discountedPrice' => $this->discountedPrice(),
                'createdAt' => $this->createdAt()->format($format),
                'updatedAt' => $this->updatedAt()->format($format),
            ],
        ];
    }

    public function product(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    protected function partNumber()
    {
        return $this->pivot?->part_number
            ?? $this->product?->part_number;
    }

    protected function acquisitionPrice()
    {
        return $this->pivot?->acquisition_price
            ?? $this->product?->list_price;
    }

    protected function discountedPrice(): ?string
    {
        if (! $this->product || ! class_exists(General::class)) {
            return null;
        }

        return (new PriceComputor($this->product->list_price, $this->product->vat_percent))
            ->discountPercent($this->product->purchaseDiscountFor($this->resource))
            ->unitaryPrice();
    }

    private function createdAt(): Carbon
    {
        return $this->pivot?->created_at ?? Carbon::now();
    }

    private function updatedAt(): Carbon
    {
        return $this->pivot?->updated_at ?? Carbon::now();
    }
}
