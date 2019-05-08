<?php

namespace Reliqui\Ambulatory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorProfileRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'practicing_from' => 'nullable|date|max:255',
            'professional_statement' => 'nullable|string|min:2|max:255',
            'specializations' => 'required|array',
            'specializations.*.id' => 'exists:ambulatory_specializations,id',
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
            'full_name' => $this->full_name,
            'slug' => $this->full_name,
            'qualification' => $this->qualification,
            'practicing_from' => $this->practicing_from,
            'professional_statement' => $this->professional_statement,
        ];
    }
}
