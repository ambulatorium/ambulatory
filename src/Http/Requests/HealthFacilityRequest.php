<?php

namespace Reliqui\Ambulatory\Http\Requests;

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
            'id' => 'required|string',
            'name' => 'required|string|min:2|max:255',
            'address' => 'required|string|min:2|max:255',
            'city' => 'required|string|min:2|max:255',
            'state' => 'nullable|string|min:2|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|min:2|max:255',
        ];
    }

    /**
     * Set the validated fields request that apply to the model.
     *
     * @return array
     */
    public function validatedFields()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zip_code' => $this->zip_code,
        ];
    }
}
