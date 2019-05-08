<?php

namespace Reliqui\Ambulatory\Http\Requests;

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
            'id' => 'required|string',
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

    /**
     * Set the validated fields request that apply to the model.
     *
     * @return array
     */
    public function validatedFields()
    {
        return [
            'id' => $this->id,
            'user_id' => auth('ambulatory')->id(),
            'form_name' => $this->form_name,
            'full_name' => $this->full_name,
            'slug' => $this->form_name.'-'.$this->full_name,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'home_phone' => $this->home_phone,
            'cell_phone' => $this->cell_phone,
            'marital_status' => $this->marital_status,
        ];
    }
}
