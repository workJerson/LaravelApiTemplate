<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'unique:users',
            ],
            'first_name' => [
                'required',
                'string',
            ],
            'last_name' => [
                'required',
                'string',
            ],
            'middle_name' => [
                'nullable',
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
            'account_type' => [
                'required',
                'numeric',
                'between:1,3',
            ],
        ];
        // Student
        if ($this->get('account_type') == 1) {
            $rules['program'] = [
                    'nullable',
                    'numeric',
                    'exists:programs,id',
                ];
            $rules['hub_id'] = [
                    'required',
                    'numeric',
                    'exists:hubs,id',
                ];
            $rules['course_id'] = [
                    'nullable',
                    'numeric',
                    'exists:courses,id',
                ];
            $rules['position'] = [
                    'required',
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
        }

        // Coordinator
        if ($this->get('account_type') == 2) {
            $rules['hub_id'] = [
                    'required',
                    'numeric',
                    'exists:hubs,id',
            ];
        }

        // Admin
        if ($this->get('account_type') == 3) {
            $rules['group_id'] = [
                    'required',
                    'numeric',
                    'exists:groups,id',
            ];
        }

        return $rules;
    }
}
