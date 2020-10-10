<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTransactionRequest extends FormRequest
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
            'event_status' => [
                'sometimes',
                'numeric',
            ],
            'program_id' => [
                'sometimes',
                'numeric',
                'exists:programs,id',
            ],
            'hub_id' => [
                'sometimes',
                'numeric',
                'exists:hubs,id',
            ],
            'status' => [
                'sometimes',
                'numeric',
            ],
        ];
    }
}
