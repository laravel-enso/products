<?php

namespace LaravelEnso\Products\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Supplier extends JsonResource
{
    public function toArray($request)
    {
        $format = config('enso.config.dateFormat');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'pivot' => $this->pivot
                ? [
                    'part_number' => $this->pivot->part_number,
                    'acquisition_price' => $this->pivot->acquisition_price,
                    'created_at' => $this->pivot->created_at->format($format),
                    'updated_at' => $this->pivot->updated_at->format($format),
                ] : [
                    'part_number' => null,
                    'acquisition_price' => null,
                    'created_at' => Carbon::now()->format($format),
                    'updated_at' => Carbon::now()->format($format),
                ],
        ];
    }
}
