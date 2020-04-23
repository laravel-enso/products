<?php

namespace LaravelEnso\Products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePictureReorderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'newIndex' => 'required|numeric|min:1',
        ];
    }
}
