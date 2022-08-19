<?php

namespace App\Http\Controllers\Admin;

use App\Http\Request\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Exception;
use Session;


class AdminAuthController extends Controller {
  public function index() {
    return view('admin.login.index');
  }

  public function login(LoginRequest $request) {
    if (!Auth::guard('admin')->attempt([
      'email' => $request->email,
      'password' => $request->password,
      'active' => true
    ], $request->remember)) {
      throw new Exception('E-mail ou senha incorretos.');
    }

    $arrPermissions = [];
    foreach(Auth::guard('admin')->user()->adminRole->adminRolePermissions as $permission) {
      array_push($arrPermissions, $permission->adminPermission->key);
    }
    Session::put('userPermission', $arrPermissions);
  }

  public function logout() {
    Auth::guard('admin')->logout();
    return redirect('admin');
  }
}
