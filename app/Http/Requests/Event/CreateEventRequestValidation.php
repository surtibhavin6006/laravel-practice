<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequestValidation extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'startDate' => [
                'required',
                'date_format:Y-m-d'
            ],
            'endDate' => [
                'present',
                'nullable',
                'required_if:endAfterOccurrences,==,null',
                'date_format:Y-m-d'
            ],
            'endAfterOccurrences' => [
                'present',
                'nullable',
                'required_if:endDate,==,null',
                'numeric',
            ],
            'repeatOn' => 'required',
            'repeatWeek' => [
                'required_if:repeatOn,==,"W"'
            ],
            'repeatMonth' => [
                'required_if:repeatOn,==,"M"'
            ]
        ];
    }
}
