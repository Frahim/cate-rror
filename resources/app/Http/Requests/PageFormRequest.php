<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'slug' => [
                'required',
                'string'
            ],
            'page_content' => [
                'nullable',
                'string'
            ],
            'page_other_content'=> [
                'nullable',
                'string'
            ],
            'banner_image' => [
                'nullable',  
                'mimes:jpg,jpeg,png,webmp'            
            ], 
            'video_url' => [
                'nullable',  
                'string'       
            ],           
            'meta_title' => [
                'nullable',
                'string'
            ],
            'meta_keyword' => [
                'nullable',
                'string'
            ],
            'meta_description' => [
                'nullable',
                'string'
            ],            
            
        ];
    }
}
