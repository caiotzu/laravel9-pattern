<?php

namespace App\Http\Controllers\Admin;

use App\Http\Request\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Exception;


class AdminAuthController extends Controller {
  public function index() {
    return view('admin.login.index');
  }

  public function login(LoginRequest $request) {
    if (!Auth::guard('admin')->attempt([
      'email' => $request->email,
      'password' => $request->password
    ], $request->remember)) {
      throw new Exception('E-mail ou senha incorretos.');
    }
  }

  public function logout() {
    Auth::guard('admin')->logout();
    return redirect('admin');
  }
}
