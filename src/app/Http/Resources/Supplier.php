<?php

namespace LaravelEnso\Products\App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Supplier extends JsonResource
{
    private string $format;

    public function toArray($request)
    {
        $this->format = config('enso.config.dateFormat');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'pivot' => $this->pivot
                ? $this->existingPivot()
                : $this->newPivot(),
        ];
    }

    private function existingPivot()
    {
        //$this->pivot->inCents(false);

        return [
            'part_number' => $this->pivot->part_number,
            'acquisition_price' => $this->pivot->acquisition_price,
            'created_at' => $this->pivot->created_at->format($this->format),
            'updated_at' => $this->pivot->updated_at->format($this->format),
        ];
    }

    private function newPivot()
    {
        return [
            'part_number' => null,
            'acquisition_price' => null,
            'created_at' => Carbon::now()->format($this->format),
            'updated_at' => Carbon::now()->format($this->format),
        ];
    }
}
