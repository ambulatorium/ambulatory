<?php

namespace Ambulatory\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'avatar' => 'required|string',
            'name' => 'required|string|min:3',
            'email' => [
                'required',
                'email',
                Rule::unique(config('ambulatory.database_connection').'.ambulatory_users', 'email')
                    ->ignore(auth('ambulatory')->id()),
            ],
        ];
    }
}
