<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\UpdateAdminUserProfileRequest;

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
      return view('admin.userProfile.index');
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar o perfil do seu usuário');
    }
  }

  public function update(UpdateAdminUserProfileRequest $request) {
    try {
      $this->adminUserService->updateAdminUserProfile($request->except('_method', '_token'));
      return view('admin.userProfile.index');
    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar os dados do usuário')->withInput();
    }
  }
}
