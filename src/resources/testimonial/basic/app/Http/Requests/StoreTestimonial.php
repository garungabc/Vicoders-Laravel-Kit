<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonial extends FormRequest
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
            'first_name' => 'required',
            'last_name'  => 'required',
            'image'      => 'required',
            'content'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'The testimonial first name field is required.',
            'last_name.required'  => 'The testimonial last name field is required.',
            'image.required'      => 'The testimonial image field is required.',
            'content.required'    => 'The testimonial content field is required.',
        ];
    }
}
