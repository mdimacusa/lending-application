<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;
use Crypt;

class UpdateClientRequest extends FormRequest
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
            'first_name'         => ['required'],
            'middle_name'        => ['nullable'],
            'surname'            => ['required'],
            'email'              => ['required','email:rfc,dns','unique:client,email,'.$id],
            'contact_number'     => ['required','numeric','unique:client,contact_number,'.$id],
            'status'             => ['required'],
            'address'            => ['nullable'],
        ];
    }
}
