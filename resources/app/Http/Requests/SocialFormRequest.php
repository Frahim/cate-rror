<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialFormRequest extends FormRequest
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
            'smname' => [
                'required',
                'string'
            ],
            'smurl' => [
                'required',
                'string'
            ],
            'socialicon' => [
                'nullable',
                'mimes:jpg,jpeg,png'
            ],
        ];
    }
}
