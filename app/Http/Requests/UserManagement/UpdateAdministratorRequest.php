<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;
use Crypt;

class UpdateAdministratorRequest extends FormRequest
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
        //get the id from url params
        $url = explode('/', url()->current());
        $id  = Crypt::decrypt(end($url));

        return [
            'name'                  => ['required'],
            'email'                 => ['required','email:rfc,dns','unique:users,email,'.$id],
            'pincode'               => ['required','numeric','digits:4'],
            'status'                => ['required'],
            'password'              => ['required','confirmed'],
        ];
    }
}
