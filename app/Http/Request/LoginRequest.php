<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
  public function rules() {
    return [
      'email' => 'required|email|exists:admin_users',
      'password' => 'required'
    ];
  }
}
