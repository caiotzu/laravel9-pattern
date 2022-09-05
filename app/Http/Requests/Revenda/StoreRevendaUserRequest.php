<?php

namespace App\Http\Requests\Revenda;

use Illuminate\Foundation\Http\FormRequest;

class StoreRevendaUserRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  protected function prepareForValidation() {
    $this->merge([
      'cpf' => preg_replace('/\D+/', '', request()->cpf),
    ]);
  }

  public function rules() {
    return [
      'name' => [
        'required',
        'string',
        'max:50',
        'min:3',
      ],
      'email' => [
        'required',
        'email',
        'unique:users'
      ],
      'cpf' => [
        'required',
        'min:11',
        'max:11',
      ],
      'role_id' => [
        'required',
      ],
    ];
  }

  public function messages() {
    return [
      'name.required' => 'O campo nome é obrigatório',
      'name.max' => 'O campo nome não pode conter mais de 50 caracteres',
      'name.min' => 'O campo nome não pode conter menos de 03 caracteres',

      'email.required' => 'O campo e-mail é obrigatório',
      'email.max' => 'O campo e-mail não pode conter mais de 100 caracteres',
      'email.email' => 'O campo e-mail não está no formato correto',
      'email.unique' => 'Este e-mail já está cadastrado para outro usuário',

      'cpf.required' => 'O cpf do usuário é obrigatório',
      'cpf.min' => 'O cpf do usuário não pode conter menos de 11 caracteres',
      'cpf.max' => 'O cpf do usuário não pode conter mais de 11 caracteres',

      'role_id.required' => 'O campo regra é obrigatório',
    ];
  }
}
