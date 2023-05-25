<?php

namespace App\Http\Requests\NewTheme;

use App\Models\LeaveType;
use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'name'           => ['required'],
            'name_ar'        => ['required'],
            'document_type'  => ['required'],
        ];
    }
}
