<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UpdateAdminUserProfileRequest;

use App\Services\AdminUserProfileService;
use App\Services\AdminUserService;

use Exception;

class AdminUserProfileController extends Controller {

  protected $adminUserService;
  protected $adminUserProfileService;

  public function __construct(AdminUserProfileService $adminUserProfileService, AdminUserService $adminUserService) {
    $this->adminUserService = $adminUserService;
    $this->adminUserProfileService = $adminUserProfileService;
  }

  public function index() {
    try {
      $user = $this->adminUserService->getAdminUserById(Auth::guard('admin')->user()->id);

      return view('admin.userProfile.index', compact('user'));
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar o perfil do seu usuário');
    }
  }

  public function update(UpdateAdminUserProfileRequest $request) {
    try {
      $user = $this->adminUserProfileService->updateAdminUserProfile($request->except('_method', '_token'));

      return redirect()->route('admin.userProfiles.index')->with([
        'successMessage' => '<strong>'.$user->name.'</strong> seu perfil foi atualizado com sucesso!'
      ]);
    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar os dados do usuário')->withInput();
    }
  }
}
