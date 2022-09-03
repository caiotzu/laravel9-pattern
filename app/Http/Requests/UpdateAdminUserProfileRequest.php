<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminUserProfileRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    return [
      'avatar' => [
        'nullable',
        'image',
        'max: 2048',
      ],
    ];
  }

  public function messages() {
    return [
      'avatar.image' => 'A imagem não tem uma extensão válida',
      'avatar.max' => 'A imagem deve ter no máximo 2048kb',
    ];
  }
}
