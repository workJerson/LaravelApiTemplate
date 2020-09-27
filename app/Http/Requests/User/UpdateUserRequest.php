<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $rules = [
            'first_name' => [
                'sometimes',
                'string',
            ],
            'last_name' => [
                'sometimes',
                'string',
            ],
            'middle_name' => [
                'sometimes',
                'string',
            ],
            'address' => [
                'required',
                'string',
            ],
            'birth_date' => [
                'sometimes',
                'string',
            ],
            'contact_number' => [
                'sometimes',
                'string',
                'min:11',
                'max:11',
            ],
        ];

        $rules['school_id'] = [
                    'sometimes',
                    'numeric',
                    'exists:schools,id',
                ];
        $rules['course_id'] = [
                    'sometimes',
                    'numeric',
                    'exists:courses,id',
                ];
        $rules['position'] = [
                    'sometimes',
                    'string',
                ];
        $rules['ccaps'] = [
                    'sometimes',
                    'string',
                ];
        $rules['letter_of_intent'] = [
                    'sometimes',
                    'string',
                ];
        $rules['pds'] = [
                    'sometimes',
                    'string',
                ];
        $rules['birth_certificate'] = [
                    'sometimes',
                    'string',
                ];
        $rules['employment_certificate'] = [
                    'sometimes',
                    'string',
                ];
        $rules['tor'] = [
                    'sometimes',
                    'string',
                ];
        $rules['honorable_dismissal'] = [
                    'sometimes',
                    'string',
                ];
        $rules['certificates'] = [
                    'sometimes',
                    'string',
                ];
        $rules['remarks'] = [
                    'sometimes',
                    'string',
                ];

        $rules['hub_id'] = [
                    'sometimes',
                    'numeric',
                    'exists:hubs,id',
            ];

        $rules['group_id'] = [
                    'sometimes',
                    'numeric',
                    'exists:groups,id',
            ];

        return $rules;
    }
}
