<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminSearchUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasAccess(['administrator']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'nullable|alpha|string|max:20',
            'last_name' => 'nullable|alpha|string|max:20',
            'email' => 'nullable|email',
            'birthdate' => 'nullable|date_format:"Y-m-d"',
            'role' => 'nullable|regex:/^[1-9]{1}$/',
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
            'role' => '',
        ];
    }
}
