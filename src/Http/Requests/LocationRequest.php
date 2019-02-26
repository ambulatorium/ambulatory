<?php

namespace Reliqui\Ambulatory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
            'id'       => 'required|string',
            'name'     => 'required|string|max:255',
            'address'  => 'required|string|max:255',
            'city'     => 'required|string|max:255',
            'state'    => 'required|string|max:255',
            'country'  => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
        ];
    }

    public function locationForm()
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'address'  => $this->address,
            'city'     => $this->city,
            'state'    => $this->state,
            'country'  => $this->country,
            'zip_code' => $this->zip_code,
        ];
    }
}
