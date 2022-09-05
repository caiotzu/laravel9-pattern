<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Request\LoginRequest;

use Exception;

class AuthController extends Controller {
  public function index() {
    return view('auth.login.index');
  }

  public function login(LoginRequest $request) {
    if (!Auth::guard('web')->attempt([
      'email' => $request->email,
      'password' => $request->password,
      'active' => true
    ], $request->remember)) {
      throw new Exception('E-mail ou senha incorretos.');
    }

    $arrPermissions = [];
    foreach(Auth::guard('web')->user()->role->rolePermissions as $permission) {
      array_push($arrPermissions, $permission->permission->key);
    }
    Session::put('userPermission', $arrPermissions);

    return [
      'profile' => strtolower(Auth::guard('web')->user()->role->company->companyGroup->profile->description),
      'permissions' => $arrPermissions
    ];
  }

  public function logout() {
    Auth::guard('web')->logout();
    return redirect('/');
  }
}
