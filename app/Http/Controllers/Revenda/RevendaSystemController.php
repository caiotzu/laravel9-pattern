<?php

namespace App\Http\Controllers\Revenda;

use App\Http\Controllers\Controller;

use App\Http\Requests\UpdateRevendaSystemRequest;

use App\Services\RevendaCompanyGroupSettingService;

use Exception;

class RevendaSystemController extends Controller {

  protected $revendaCompanyGroupSettingService;

  public function __construct(RevendaCompanyGroupSettingService $revendaCompanyGroupSettingService) {
    $this->revendaCompanyGroupSettingService = $revendaCompanyGroupSettingService;
  }

  public function index() {
    try {
      $settings = $this->revendaCompanyGroupSettingService->listAllRevendaCompanyGroupSettingsInArrayFormat();

      return view('revenda.system.index', compact('settings'));
    } catch (Exception $e) {
      return redirect()->route('revenda.home.index')->withErrors('Não foi possível carregar as configurações do sistema');
    }
  }

  public function update(UpdateRevendaSystemRequest $request) {
    try {
      $this->revendaCompanyGroupSettingService->createOrUpdateRevendaSettings($request->except('_method', '_token'));

      return redirect()->route('revenda.systems.index')->with([
        'successMessage' => 'As configurações do <strong>sistema</strong> foram atualizadas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar as configurações do sistema')->withInput();
    }
  }
}
