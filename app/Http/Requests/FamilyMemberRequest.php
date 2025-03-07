<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'marital_status' => 'required|string|in:Married,Unmarried',
            'wedding_date' => 'nullable|date|required_if:marital_status,Married',
            'education' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ];
    }
}
