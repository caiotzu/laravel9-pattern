<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller {

  public function index() {
    // dd(Auth::guard('admin')->user()->role->rolePermissions);
    return view('admin.user.index');
  }
}
