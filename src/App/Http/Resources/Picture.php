<?php

namespace LaravelEnso\Products\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelEnso\Files\App\Http\Resources\File;

class Picture extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'orderIndex' => $this->order_index,
            'file' => new File($this->whenLoaded('file')),
        ];
    }
}
