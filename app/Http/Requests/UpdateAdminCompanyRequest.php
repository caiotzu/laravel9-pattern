<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminCompanyRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  protected function prepareForValidation() {
    $this->merge([
      'cnpj' => preg_replace('/\D+/', '', request()->cnpj)
    ]);
  }

  public function rules() {
    $id = $this->id ?? '';

    return [
      'company_group_id' => [
        'required',
      ],
      'company_type' => [
        'required',
      ],
      'headquarter_id' => [
        'nullable',
        'required_if:company_type,filial',
      ],
      'cnpj' => [
        'required',
        'min:14',
        'max:14',
        "unique:companies,cnpj,{$id},id"
      ],
      'trade_name' => [
        'required',
        'min:3',
        'max:60'
      ],
      'company_name' => [
        'required',
        'min:3',
        'max:60'
      ],
      'state_registration' => [
        'required',
        'max:9'
      ],
      'municipal_registration' => [
        'required',
        'max:11'
      ],
    ];
  }

  public function messages() {
    return [
      'company_group_id.required' => 'O campo grupo empresa é obrigatório',

      'company_type.required' => 'O campo tipo empresa é obrigatório',

      'headquarter_id.required_if' => 'O campo filial da empresa é obrigatório quando o tipo da empresa é filial',

      'cnpj.required' => 'O campo cnpj é obrigatório',
      'cnpj.min' => 'O campo cnpj não pode conter menos de 14 caracteres',
      'cnpj.max' => 'O campo cnpj não pode conter mais de 14 caracteres',
      'cnpj.unique' => 'Este cnpj já está cadastrado para outra empresa',


      'trade_name.required' => 'O campo nome fantasia é obrigatório',
      'trade_name.min' => 'O campo nome fantasia não pode conter menos de 03 caracteres',
      'trade_name.max' => 'O campo nome fantasia não pode conter mais de 60 caracteres',

      'company_name.required' => 'O campo razão social é obrigatório',
      'company_name.min' => 'O campo razão social não pode conter menos de 03 caracteres',
      'company_name.max' => 'O campo razão social não pode conter mais de 60 caracteres',

      'state_registration.required' => 'O campo inscrição estadual é obrigatório',
      'state_registration.max' => 'O campo inscrição estadual não pode conter mais de 09 caracteres',

      'municipal_registration.required' => 'O campo inscrição municipal é obrigatório',
      'municipal_registration.max' => 'O campo inscrição municipal não pode conter mais de 11 caracteres',
    ];
  }
}
