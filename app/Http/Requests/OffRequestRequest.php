<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffRequestRequest extends FormRequest
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
        $rules=[];
        //Let's make our Request Validator More flexible
        // dd($this->all());
        //this condition check if the request come from create page or Status Modal
        if(!$this->isInModal){
            $rules= [
                'label'=>'required|max:29',
                'description'=>'required|min:20|max:255',
                'type'=>'required',
                'justification'=> is_string($this->justification) ?  'required|max:199' : 'required|array',
                'start_date'=>'required|date',
                'end_date'=>'required|date',
                'status_answer'=>'nullable|max:255'
            ];
        }else {
            $rules= [
                'status'=>'required',
                'status_answer'=>'nullable|max:255'
            ];
        }

        return $rules;

    }
}
