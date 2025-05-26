<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Manipular falha de validação e retornar uma resposta JSON com os erros de validação.
     * 
     *   @param \illuminate\Contracts\Validation\Validato $validator o objeto de validação que contem os
     * erros de validação.
     * 
     *   @throws  \illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors()
        ], 422)) ;  
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email,' .($userId ? $userId->id : null),
            'password' => 'required|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo é obrigatorio!',
            'name.min' => 'O campo deve ter no minimo 3 caracteres!',
            'name.max' => 'O campo deve ter no maximo 50 caracteres!',

            'email.required' => 'O campo é obrigatorio!',
            'email.email' => 'Nessesario enviar e-mail valido!',
            'email.unique ' => 'O campoja esta cadastrado!',

            'password.required' => 'O campo é obrigatorio!',
            'password.min' => 'O campo deve ter no minimo :min caracteres!',
        ];
    }
}
