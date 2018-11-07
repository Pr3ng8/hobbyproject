<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => 'required|alpha|string|max:20',
            'last_name' => 'required|alpha|string|max:20',
            'email' => 'required|email|unique:users,email'.$this->id,
            'birthdate' => 'required|date_format:"Y-m-d"',
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
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'birthdate' => '',
        ];
    }
}
