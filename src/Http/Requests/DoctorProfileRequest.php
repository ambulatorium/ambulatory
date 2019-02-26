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
            'id' => 'required',
            'full_name' => 'required|string|max:255',
            'years_of_experience' => 'required|numeric',
            'qualification' => 'required|string|max:255',
            'bio' => 'nullable|string|max:255',
            'specialities' => 'array',
            'specialities.*.id' => 'exists:reliqui_specialities,id',
        ];
    }

    public function formDoctor()
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'years_of_experience' => $this->years_of_experience,
            'qualification' => $this->qualification,
            'bio' => $this->bio,
        ];
    }
}
