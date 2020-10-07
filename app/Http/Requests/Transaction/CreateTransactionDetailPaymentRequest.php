<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionDetailPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transaction_detail_id' => [
                'required',
                'numeric',
                'exists:transaction_details,id',
            ],
            'official_receipt_number' => [
                'sometimes',
                'string',
            ],
            'session_cost' => [
                'numeric',
                'sometimes',
                'between:0.000001,999999999999.999999',
            ],
            'registration_fee' => [
                'numeric',
                'sometimes',
                'between:0.000001,999999999999.999999',
            ],
            'food_fee' => [
                'numeric',
                'sometimes',
                'between:0.000001,999999999999.999999',
            ],
        ];
    }
}
