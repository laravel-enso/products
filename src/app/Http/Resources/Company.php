<?php

namespace LaravelEnso\Products\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
{
    public function toArray($request)
    {
        \Log::debug($this->pivot);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'pivot' => $this->pivot
                ? [
                    'part_number' => $this->pivot->part_number,
                    'acquisition_price' => $this->pivot->acquisition_price,
                    'created_at' => $this->pivot->created_at->format(config('enso.config.dateFormat')),
                    'updated_at' => $this->pivot->updated_at->format(config('enso.config.dateFormat')),
                ] : [
                    'part_number' => null,
                    'acquisition_price' => null,
                    'created_at' => null,
                    'updated_at' => null,
                ],
        ];
    }
}
