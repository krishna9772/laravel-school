<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'user_name' => 'required|string|max:50',
            'user_type' => 'required|string|max:30',
            'gender' => 'nullable|string|max:30',
            'grade_select' => 'required',
            'class_select' => 'required',
            'nrc' => 'nullable|string|max:50',
            'admission_date' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'father_name' => 'nullable|string|max:50',
            'mother_name' => 'nullable|string|max:50',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string|max:100',
            'former_school' => 'nullable|string|max:100'
        ];
    }
}
