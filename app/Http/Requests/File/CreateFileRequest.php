<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'private' => 'sometimes',
            'files' => 'sometimes|required|array',
            'files.*' => [
                'sometimes',
                'required',
                'mimes:pdf,jpg,jpeg,png,bmp',
                'max:4096',
            ],
            'file' => [
                'sometimes',
                'required',
                'mimes:pdf,jpg,jpeg,png,bmp',
                'max:4096',
            ],
        ];
    }
}
