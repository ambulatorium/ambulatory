<?php

namespace Reliqui\Ambulatory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecializationRequest extends FormRequest
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
            'description' => 'nullable|string|min:2|max:255',
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
            'description' => $this->description,
        ];
    }
}
