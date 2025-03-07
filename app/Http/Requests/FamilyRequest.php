<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'mobile_no' => 'required|string|regex:/^[0-9]{10}$/',
            'address' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string|regex:/^[0-9]{6}$/',
            'marital_status' => 'required|string|in:Married,Unmarried',
            'wedding_date' => 'nullable|date|required_if:marital_status,Married',
            'hobbies' => 'nullable|array',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ];
    }
}
