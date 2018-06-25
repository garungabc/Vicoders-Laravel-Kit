<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'email'           => 'required|email|max:50',
            'password'        => 'required|min:6|max:30',
            'first_name'      => 'required|regex:/[a-z0-9\s]*/i|max:20',
            'last_name'       => 'required|regex:/[a-z0-9\s]*/i|max:20',
            'phone_area_code' => 'required|regex:/^\d+$/|max:5',
            'phone_number'    => 'required|regex:/^\d+$/|max:15',
        ];
    }

    public function messages()
    {
        return [
            'email.required'           => 'The email field is required.',
            'email.email'              => 'The email field format is not valid.',
            'email.max'                => 'The email field must be smaller :max character.',

            'password.required'        => 'The password field is required.',
            'password.min'             => 'The password field must be larger :min character.',
            'password.max'             => 'The password field must be smaller :max character.',

            'first_name.required'      => 'The first name field is required.',
            'first_name.regex'         => 'The first name field format is not valid.',
            'first_name.max'           => 'The first name field must be smaller :max character.',

            'last_name.required'       => 'The last name field is required.',
            'last_name.regex'          => 'The last name field format is not valid.',
            'last_name.max'            => 'The last name field must be smaller :max character.',

            'phone_area_code.required' => 'The phone area code field is required.',
            'phone_area_code.regex'    => 'The phone area code field format is not valid.',
            'phone_area_code.max'      => 'The phone area code field must be smaller :max character.',

            'phone_number.required'    => 'The phone number field is required.',
            'phone_number.regex'       => 'The phone number field format is not valid.',
            'phone_number.max'         => 'The phone number field must be smaller :max character.',
        ];
    }
}
