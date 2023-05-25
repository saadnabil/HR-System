<?php

namespace App\Http\Requests\Landpage\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreForm extends FormRequest
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
            'name' => ['required' , 'string'],
            'email' => ['required' , 'email'],
            'subject' => ['nullable' , 'string' ,'in:question,complaint,appointment'],
            'message' => ['required' , 'string'],
        ];
    }
}
