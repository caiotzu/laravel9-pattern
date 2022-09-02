<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Services\AdminUserService;
use App\Services\AdminRoleService;

use Exception;

class AdminUserProfileController extends Controller {

  protected $adminUserService;
  protected $adminRoleService;

  public function __construct(AdminUserService $adminUserService, AdminRoleService $adminRoleService) {
    $this->adminUserService = $adminUserService;
    $this->adminRoleService = $adminRoleService;
  }

  public function index() {
    try {
      // dd(Auth::guard('admin')->user());
      return view('admin.userProfile.index');
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar o perfil do seu usuário');
    }
  }
}
