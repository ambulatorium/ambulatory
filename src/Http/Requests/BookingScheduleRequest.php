<?php

namespace Reliqui\Ambulatory\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Reliqui\Ambulatory\Rules\BookingAvailabilityRule;

class BookingScheduleRequest extends FormRequest
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
        $schedule = $this->route('schedule');

        return [
            'preferred_date_time' => [
                'bail',
                'required',
                'date',
                'after_or_equal:'.$schedule->start_date,
                'before_or_equal:'.$schedule->end_date,
                Rule::unique(config('ambulatory.database_connection').'.reliqui_bookings', 'preferred_date_time')
                    ->where('schedule_id', $schedule->id),
                new BookingAvailabilityRule($schedule),
            ],
            'medical_form_id' => [
                'bail',
                'required',
                'string',
                Rule::exists(config('ambulatory.database_connection').'.reliqui_medical_forms', 'id')
                    ->where('user_id', auth('ambulatory')->id()),
            ],
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'medical_form_id' => 'medical form',
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
            'preferred_date_time.unique' => 'The preferred date time has already been booked.',
        ];
    }
}
