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
        $rules =  [
            'user_name' => 'required|string|max:50',
            'user_type' => 'required|string|max:30',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'gender' => 'nullable|string|max:30',
            'grade_select' => 'required',
            'class_select' => 'required',
            'nrc' => 'nullable|string|max:50',
            'admission_date' => 'nullable|date',
            'date_of_birth' => 'nullable|date|before_or_equal:today',
            'father_name' => 'nullable|string|max:50',
            'mother_name' => 'nullable|string|max:50',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string|max:100',
            'former_school' => 'nullable|string|max:100',
            'teacher_type' => 'required_if:user_type,teacher',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules =  [
                'user_name' => 'required|string|max:50',
                'user_type' => 'required|string|max:30',
                'email' => 'required',
                'confirm_password' => 'same:password',
                'gender' => 'nullable|string|max:30',
                'grade_select' => 'required',
                'class_select' => 'required',
                'nrc' => 'nullable|string|max:50',
                'admission_date' => 'nullable|date',
                'date_of_birth' => 'nullable|date|before_or_equal:today',
                'father_name' => 'nullable|string|max:50',
                'mother_name' => 'nullable|string|max:50',
                'phone_number' => 'nullable|string',
                'address' => 'nullable|string|max:100',
                'former_school' => 'nullable|string|max:100',
                'teacher_type' => 'required_if:user_type,teacher',
            ];
    
        }

        return $rules;
    }

    public function messages()
    {
        return [
           'date_of_birth.before_or_equal' => 'Invalid Date'
        ];
    }
}
