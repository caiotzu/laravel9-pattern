<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\IndexAdminCompanyRequest;
use App\Http\Requests\StoreAdminPermissionRequest;
use App\Http\Requests\UpdateAdminPermissionRequest;

use App\Services\ProfileService;
use App\Services\AdminCompanyService;
use App\Services\AdminCompanyGroupService;

use Exception;

class AdminCompanyController extends Controller {

  protected $profile;
  protected $adminCompanyService;
  protected $adminCompanyGroupService;


  public function __construct(
    AdminCompanyService $adminCompanyService,
    ProfileService $profile,
    AdminCompanyGroupService $adminCompanyGroupService
  ) {
    $this->profile = $profile;
    $this->adminCompanyService = $adminCompanyService;
    $this->adminCompanyGroupService = $adminCompanyGroupService;
  }

  public function index(IndexAdminCompanyRequest $request) {
    try {
      $data = $request->all();
      $filters = [];

      if($request->company_id)
        $filters['id'] = $request->company_id;

      if($request->profile_id)
        $filters['profile_id'] = $request->profile_id;

      $companies = $this->adminCompanyService->listAllCompanies();
      $profiles = $this->profile->listAllProfiles();
      $filteredList = $this->adminCompanyService->listAllCompaniesWithPagination($filters);

      return view('admin.company.index', compact('companies', 'profiles', 'data', 'filteredList'));
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar a lista de empresas');
    }
  }

  public function create() {
    try {
      $companyGroups = $this->adminCompanyGroupService->listAllCompanyGroups();

      return view('admin.company.create', compact('companyGroups'));
    } catch (Exception $e) {
      return redirect()->route('admin.companies.index')->withErrors('Não foi possível carregar o formulário de cadastro da empresa');
    }
  }

  public function store(StoreAdminPermissionRequest $request) {
    try {
      $this->adminPermissionService->createAdminRolePermission($request->except('_method', '_token'));

      return redirect()->route('admin.permissions.index')->with([
        'successMessage' => 'As permissões para a função <strong>'.$request->description.'</strong> foram cadastradas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao cadastrar os as permissões')->withInput();
    }
  }

  public function edit($id) {
    try {
      [$role, $permissions] = $this->adminPermissionService->listAllAdminPermissionsGroupedByViewAndThatTheRoleHasAccess($id);

      return view('admin.permission.edit', compact('role', 'permissions'));
    } catch (Exception $e) {
      return back()->withErrors('Não foi possível carregar o formulário de edição das permissões, função não encontrada')->withInput();
    }
  }

  public function update(UpdateAdminPermissionRequest $request, $id) {
    try {
      $this->adminPermissionService->updateAdminRolePermission($id, $request->except('_method', '_token'));

      return redirect()->route('admin.permissions.index')->with([
        'successMessage' => 'As permissões para a função <strong>'.$request->description.'</strong> foram atualizadas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar as permissões')->withInput();
    }
  }
}
