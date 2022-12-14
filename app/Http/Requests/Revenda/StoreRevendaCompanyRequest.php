<?php

namespace App\Http\Requests\Revenda;

use Illuminate\Foundation\Http\FormRequest;

class StoreRevendaCompanyRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  protected function prepareForValidation() {
    $addresses = json_decode(request()->arrAddress);
    foreach($addresses as $key => $address) {
      $address->zipCode = preg_replace('/\D+/', '', $address->zipCode);
      $addresses[$key] = $address;
    }

    $this->merge([
      'cnpj' => preg_replace('/\D+/', '', request()->cnpj),
      'user_cpf' => preg_replace('/\D+/', '', request()->user_cpf),
      'arrAddress' => json_encode($addresses)
    ]);
  }

  public function rules() {
    return [
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
        'unique:companies'
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
      'arrContact' => [
        function ($attribute, $value, $fail) {
          $contacts = json_decode($value);
          $totalContactEmailMain = 0;
          $existEmail = false;
          $totalContactPhoneMain = 0;
          $existPhone = false;

          foreach($contacts as $contact) {
            if($contact->insert == 'S') {
              if($contact->type == 'E') {
                $existEmail = true;

                if($contact->main && $contact->active)
                  $totalContactEmailMain++;

                foreach($contact as $field) {
                  if($field === '' || $field === null)
                    $fail('Todos os campos do contato devem ser preenchidos');
                }
              } else if($contact->type == 'T') {
                $existPhone = true;

                if($contact->main && $contact->active)
                  $totalContactPhoneMain++;

                foreach($contact as $field) {
                  if($field === '' || $field === null)
                    $fail('Todos os campos do contato devem ser preenchidos');
                }
              }
            }
          }

          if($existEmail) {
            if($totalContactEmailMain > 1)
              $fail('S?? pode ter um e-mail cadastrado como principal');
            else if($totalContactEmailMain == 0)
              $fail('Obrigat??rio definir um e-mail como principal e ativo');
          }

          if($existPhone) {
            if($totalContactPhoneMain > 1)
              $fail('S?? pode ter um telefone cadastrado como principal');
            else if($totalContactPhoneMain == 0)
              $fail('Obrigat??rio definir telefone como principal e ativo');
          }
        },
      ],
      'arrAddress' => [
        function ($attribute, $value, $fail) {
          $addresses = json_decode($value);
          $totalAddresstMain = 0;
          $existAddress = false;

          foreach($addresses as $address) {
            if($address->insert == 'S') {
              $existAddress = true;

              if($address->main && $address->active)
                $totalAddresstMain++;

              foreach($address as $key => $field) {
                if(($field === '' || $field === null) && $key != 'complement')
                  $fail('Todos os campos obrigat??rios do endere??o devem ser preenchidos');
              }
            }
          }

          if($existAddress) {
            if($totalAddresstMain > 1)
              $fail('S?? pode ter um endere??o cadastrado como principal');
            else if($totalAddresstMain == 0)
              $fail('Obrigat??rio definir um endere??o como principal e ativo');
          }
        },
      ],
      'user_name' => [
        'required',
        'string',
        'max:50',
        'min:3',
      ],
      'user_email' => [
        'required',
        'email',
        "unique:users,email"
      ],
      'user_cpf' => [
        'required',
        'min:11',
        'max:11',
      ],
    ];
  }

  public function messages() {
    return [
      'company_type.required' => 'O campo tipo empresa ?? obrigat??rio',

      'headquarter_id.required_if' => 'O campo filial da empresa ?? obrigat??rio quando o tipo da empresa ?? filial',

      'cnpj.required' => 'O campo cnpj ?? obrigat??rio',
      'cnpj.min' => 'O campo cnpj n??o pode conter menos de 14 caracteres',
      'cnpj.max' => 'O campo cnpj n??o pode conter mais de 14 caracteres',
      'cnpj.unique' => 'Este cnpj j?? est?? cadastrado para outra empresa',

      'trade_name.required' => 'O campo nome fantasia ?? obrigat??rio',
      'trade_name.min' => 'O campo nome fantasia n??o pode conter menos de 03 caracteres',
      'trade_name.max' => 'O campo nome fantasia n??o pode conter mais de 60 caracteres',

      'company_name.required' => 'O campo raz??o social ?? obrigat??rio',
      'company_name.min' => 'O campo raz??o social n??o pode conter menos de 03 caracteres',
      'company_name.max' => 'O campo raz??o social n??o pode conter mais de 60 caracteres',

      'state_registration.required' => 'O campo inscri????o estadual ?? obrigat??rio',
      'state_registration.max' => 'O campo inscri????o estadual n??o pode conter mais de 09 caracteres',

      'municipal_registration.required' => 'O campo inscri????o municipal ?? obrigat??rio',
      'municipal_registration.max' => 'O campo inscri????o municipal n??o pode conter mais de 11 caracteres',

      'user_name.required' => 'O nome do usu??rio respons??vel ?? obrigat??rio',
      'user_name.max' => 'O nome do usu??rio respons??vel n??o pode conter mais de 50 caracteres',
      'user_name.min' => 'O nome do usu??rio respons??vel n??o pode conter menos de 03 caracteres',

      'user_email.required' => 'O e-mail do usu??rio respons??vel ?? obrigat??rio',
      'user_email.max' => 'O e-mail do usu??rio respons??vel n??o pode conter mais de 100 caracteres',
      'user_email.email' => 'O e-mail do usu??rio respons??vel n??o est?? no formato correto',
      'user_email.unique' => 'Este e-mail do usu??rio respons??vel j?? est?? cadastrado para outro usu??rio',

      'user_cpf.required' => 'O cpf do usu??rio respons??vel ?? obrigat??rio',
      'user_cpf.min' => 'O cpf do usu??rio respons??vel n??o pode conter menos de 11 caracteres',
      'user_cpf.max' => 'O cpf do usu??rio respons??vel n??o pode conter mais de 11 caracteres',
    ];
  }
}
