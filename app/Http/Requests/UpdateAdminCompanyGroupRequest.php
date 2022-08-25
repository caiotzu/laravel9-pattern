<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminCompanyGroupRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    return [
      'group_name' => [
        'required',
        'string',
        'max:50',
        'min:3',
      ],
      'profile_id' => [
        'required',
      ]
    ];
  }

  public function messages() {
    return [
      'group_name.required' => 'O campo nome do grupo é obrigatório',
      'group_name.string' => 'O campo nome do grupo deve ser um texto',
      'group_name.max' => 'O campo nome do grupo não pode conter mais de 50 caracteres',
      'group_name.min' => 'O campo nome do grupo não pode conter menos de 03 caracteres',

      'profile_id.required' => 'O campo perfil é obrigatório',
    ];
  }
}
