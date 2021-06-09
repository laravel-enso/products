<?php

namespace LaravelEnso\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class ValidatePictureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rule = 'required|image|max:8192';

        return Collection::wrap($this->allFiles())->keys()
            ->mapWithKeys(fn ($key) => [$key => $rule])->toArray();
    }

    public function messages()
    {
        return [
            'image' => 'Only images are allowed',
        ];
    }
}
