<?php

namespace Ambulatory\Ambulatory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleAvailabilityRequest extends FormRequest
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
            'intervals' => 'required|array',
            'intervals.*.from' => 'required|string',
            'intervals.*.to' => 'required|string',
            'date' => 'required|date',
        ];
    }
}
