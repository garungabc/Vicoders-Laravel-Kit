<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
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
            'title'       => 'required',
            'image'       => 'required',
            'description' => 'required',
            'content'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'       => 'The post title field is required.',
            'image.required'       => 'The post image field is required.',
            'description.required' => 'The post description field is required.',
            'content.required'     => 'The post content field is required.',
        ];
    }
}
