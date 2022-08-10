<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminHomeController extends Controller {
  public function index() {
    dd('chegou aqui, montar o index', Auth::guard('admin')->user()->name);
  }
}
