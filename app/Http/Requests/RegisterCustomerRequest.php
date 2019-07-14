<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCustomerRequest extends FormRequest
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
            'firstname' => 'required|string|alpha',
            'lastname' => 'required|string|alpha',
            'phone' => 'required|digits:10|unique:customers,phone',
            'email' => 'required|email|unique:customers,email',
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
            'firstname.required' => 'FirstName is required',
            'firstname.alpha' => 'Only letters are required for FirstName',
            'lastname.required' => 'Lastname is required',
            'firstname.alpha' => 'Only letters are required for LasttName',
            'phone.required' => 'Phone number is required',
            'phone.digits' => 'Wrong phone numnber, correct format 0712733814',
            'email.required' => 'Email address is required',
            'email.email' => 'Email address is invalid',
        ];
    }
}
