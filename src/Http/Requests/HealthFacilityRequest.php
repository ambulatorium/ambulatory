<?php

namespace Ambulatory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HealthFacilityRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'address' => 'required|string|min:2|max:255',
            'city' => 'required|string|min:2|max:255',
            'state' => 'nullable|string|min:2|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|min:2|max:255',
        ];
    }
}
