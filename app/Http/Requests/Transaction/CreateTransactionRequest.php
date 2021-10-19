<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
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
            'program_id' => [
                'required',
                'numeric',
                'exists:programs,id',
            ],
            'course_id' => [
                'required',
                'numeric',
                'exists:courses,id',
            ],
            'student_id' => [
                'required',
                'numeric',
                'exists:students,id',
            ],
            // 'start_month' => [
            //     'required',
            //     'string',
            // ],
        ];
    }
}
