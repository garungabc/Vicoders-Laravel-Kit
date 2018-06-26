<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'name'        => 'required',
            'image'       => 'required',
            'description' => 'required',
            'price'       => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'The product name field is required.',
            'image.required'       => 'The product image field is required.',
            'description.required' => 'The product description field is required.',
            'price.required'       => 'The product price field is required.',
            'price.numeric'        => 'The product price field must be numeric.',
        ];
    }
}
