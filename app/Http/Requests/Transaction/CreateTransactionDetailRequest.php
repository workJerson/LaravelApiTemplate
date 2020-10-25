<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTransactionDetailRequest extends FormRequest
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
            'transaction_id' => [
                'required',
                'numeric',
                'exists:transactions,id',
            ],
            'type' => [
                'required',
                'string',
            ],
            'transaction_date' => [
                'required',
                'string',
            ],
            'session_cost' => [
                'numeric',
                'required',
                'between:0.000001,999999999999.999999',
            ],
        ];
    }
}
