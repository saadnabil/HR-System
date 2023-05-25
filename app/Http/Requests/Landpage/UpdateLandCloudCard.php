<?php

namespace App\Http\Requests\Landpage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLandCloudCard extends FormRequest
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
            //
            'number' => ['nullable' , 'numeric','min:1' , 'max:100'],
            'descriptionEn' => ['nullable' , 'string'],
            'descriptionAr' => ['nullable' , 'string'],
            'image' => ['nullable' , 'image'],

        ];
    }
}
