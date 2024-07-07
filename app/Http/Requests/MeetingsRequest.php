<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'responsible_id'=>'required',
            'participants_id'=>'required|array',
            'start_date'=>'required|date|after_or_equal:today',
            'end_date'=>'required|date|after:start_date',
            'description'=>'nullable|min:10'
        ];
    }

    public function messages(): array
    {
        return [
            'responsible_id'=>'You need to select a responsible',
            'participants_id'=>'You need to select at leat one participant',
            'start_date'=>'Start date is required',
            'start_date.after_or_equal'=>'Start date Need to be after or equal to today',
            'end_date.after'=>'End date Needs To be after Start Date'
        ];
    }
}
