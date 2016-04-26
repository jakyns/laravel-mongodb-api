<?php

namespace Api\Requests\User;

use Dingo\Api\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'firstname'             => 'required|string|max:255',
            'lastname'              => 'required|string|max:255',
            'email'                 => 'required|email|unique:users|max:255',
            'password'              => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password|min:8|max:255',
            'country'               => 'required|min:2|max:5',
        ];
    }
}
