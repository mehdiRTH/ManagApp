<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnounceRequest extends FormRequest
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
            'label'=>'required|max:100',
            'message'=>'required|max:255|min:10',
            'receiver'=>'required_if:type,Section,Direct',
            'type'=>'required',
            'is_active'=>'required',
            'status'=>'required',
            'end_date'=>'nullable|after_or_equal:today'
        ];
    }
}
