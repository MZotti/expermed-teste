<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'files' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'files.required' => 'É necessário anexar um arquivo.'
        ];
    }
}
