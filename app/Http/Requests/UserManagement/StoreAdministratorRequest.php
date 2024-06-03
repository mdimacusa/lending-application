<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdministratorRequest extends FormRequest
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
            'first_name'            => ['required'],
            'middle_name'           => ['nullable'],
            'surname'               => ['required'],
            'email'                 => ['required','email:rfc,dns','unique:users,email'],
            'pincode'               => ['required','numeric','digits:4'],
            'password'              => ['required','confirmed'],
            'password_confirmation' => ['required'],
        ];
    }
}
