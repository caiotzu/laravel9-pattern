<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreAdminPermissionRequest;
use App\Http\Requests\UpdateAdminUserRequest;

use App\Services\AdminRoleService;
use App\Services\AdminPermissionService;


use Exception;

class AdminPermissionController extends Controller {

  protected $adminRoleService;
  protected $adminPermissionService;

  public function __construct(AdminRoleService $adminRoleService, AdminPermissionService $adminPermissionService) {
    $this->adminRoleService = $adminRoleService;
    $this->adminPermissionService = $adminPermissionService;
  }

  public function index() {
    try {
      $roles = $this->adminRoleService->listAllAdminRolesWithPagination();

      return view('admin.permission.index', compact('roles'));
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar a lista de permissões');
    }
  }

  public function create() {
    try {
      $permissions = $this->adminPermissionService->listAllPermissionsGroupedByView();

      return view('admin.permission.create', compact('permissions'));
    } catch (Exception $e) {
      return redirect()->route('admin.permissions.index')->withErrors('Não foi possível carregar o formulário de cadastro das permissões');
    }
  }

  public function store(StoreAdminPermissionRequest $request) {
    try {
      $this->adminPermissionService->createRolePermission($request->except('_method', '_token'));

      return redirect()->route('admin.permissions.index')->with([
        'successMessage' => 'As permissões para a função <strong>'.$request->description.'</strong> foram cadastradas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao cadastrar os as permissões')->withInput();
    }
  }

  public function edit($id) {
    try {
      $user = $this->adminUserService->getAdminUserById($id);
      $roles = $this->adminRoleService->listAllAdminRoles();

      return view('admin.user.edit', compact('roles', 'user'));
    } catch (Exception $e) {
      return back()->withErrors('Usuário não encontrado')->withInput();
    }
  }

  public function update(UpdateAdminUserRequest $request, $id) {
    try {
      $user = $this->adminUserService->updateAdminUser($id, $request->all());

      return redirect()->route('admin.users.index')->with([
        'successMessage' => 'O usuário <strong>'.$user->name.'</strong> foi atualizado com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Não foi possível atualizar os dados do usuário')->withInput();
    }
  }
}
