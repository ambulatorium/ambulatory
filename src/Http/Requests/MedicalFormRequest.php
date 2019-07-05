<?php

namespace Ambulatory\Ambulatory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicalFormRequest extends FormRequest
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
            'form_name' => 'required|string|min:2|max:225',
            'full_name' => 'required|string|min:2|max:225',
            'dob' => 'required|date',
            'gender' => 'required|string|min:2|max:225',
            'address' => 'required|string|min:2|max:225',
            'city' => 'required|string|min:2|max:225',
            'state' => 'nullable|string|min:2|max:225',
            'zip_code' => 'required|string|min:2|max:225',
            'home_phone' => 'nullable|string|min:2|max:225',
            'cell_phone' => 'required|string|min:2|max:225',
            'marital_status' => 'required|string|min:2|max:225',
        ];
    }
}
