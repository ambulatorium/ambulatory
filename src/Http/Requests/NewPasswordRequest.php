<?php

namespace Reliqui\Ambulatory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Reliqui\Ambulatory\Rules\CurrentPassRule;

class NewPasswordRequest extends FormRequest
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
            'current_password' => ['required', 'string', 'min:6', new CurrentPassRule],
            'new_password' => 'required|string|min:6',
            'confirm_new_password' => 'required|string|min:6|same:new_password',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'confirm_new_password.same' => 'Password confirmation should match to the new password',
        ];
    }
}
