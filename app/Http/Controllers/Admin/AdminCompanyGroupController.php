<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreAdminCompanyGroupRequest;
use App\Http\Requests\UpdateAdminCompanyGroupRequest;

use App\Services\AdminCompanyGroupService;
use App\Services\ProfileService;

use Exception;

class AdminCompanyGroupController extends Controller {

  protected $adminCompanyGroupService;
  protected $profile;

  public function __construct(AdminCompanyGroupService $adminCompanyGroupService, ProfileService $profile) {
    $this->adminCompanyGroupService = $adminCompanyGroupService;
    $this->profile = $profile;
  }

  public function index() {
    try {
      $companyGroups = $this->adminCompanyGroupService->listAllCompanyGroupsWithPagination();

      return view('admin.companyGroup.index', compact('companyGroups'));
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar a lista de grupos de empresas');
    }
  }

  public function create() {
    try {
      $profiles = $this->profile->listAllProfiles();
      return view('admin.companyGroup.create', compact('profiles'));
    } catch (Exception $e) {
      return redirect()->route('admin.users.index')->withErrors('Não foi possível carregar o formulário de cadastro do grupo de empresas');
    }
  }

  public function store(StoreAdminCompanyGroupRequest $request) {
    try {
      $companyGroup = $this->adminCompanyGroupService->createCompanyGroup($request->all());

      return redirect()->route('admin.companyGroups.index')->with([
        'successMessage' => 'O grupo de empresas <strong>'.$companyGroup->group_name.'</strong> foi cadastrado com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao cadastrar os dados do grupo de empresas')->withInput();
    }
  }

  public function edit($id) {
    try {
      $companyGroup = $this->adminCompanyGroupService->getCompanyGroupById($id);
      $profiles = $this->profile->listAllProfiles();

      return view('admin.companyGroup.edit', compact('profiles', 'companyGroup'));
    } catch (Exception $e) {
      return back()->withErrors('Grupo de empresas não encontrado')->withInput();
    }
  }

  public function update(UpdateAdminCompanyGroupRequest $request, $id) {
    try {
      $companyGroup = $this->adminCompanyGroupService->updateCompanyGroup($id, $request->all());

      return redirect()->route('admin.companyGroups.index')->with([
        'successMessage' => 'O grupo de empresas <strong>'.$companyGroup->group_name.'</strong> foi atualizado com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Não foi possível atualizar os dados do grupo de empresas')->withInput();
    }
  }
}
