<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Company;
use App\Models\AdminSetting;

use Exception;

class AdminCompanyService {
  public function listAllCompanies(): Collection {
    return Company::get();
  }

  public function listAllCompaniesExcept(Int $id): Collection {
    return Company::whereNot('id', $id)->get();
  }

  public function listAllCompaniesWithPagination(Array $filters = []): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;

    return Company::with('companyGroup.profile')
    ->where(function ($query) use ($filters) {
      if(isset($filters['id']))
        return $query->where('id', $filters['id']);
    })
    ->whereHas('companyGroup.profile', function ($query) use ($filters) {
      if(isset($filters['profile_id']))
        return $query->where('id', $filters['profile_id']);
    })
    ->paginate($recordPerPage);
  }

  public function getCompanyById(Int $id): Company {
    return Company::findOrFail($id);
  }

  public function createAdminCompany(Array $dto) {
    try {
      DB::beginTransaction();
        $dto['active'] = isset($dto['active']) ? true : false;
        $dto['headquarter_id'] = $dto['company_type'] == 'filial' ? $dto['headquarter_id'] : null;

        $company = Company::create($dto);
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }

  public function updateAdminCompany(Int $id, Array $dto) {
    try {
      DB::beginTransaction();
        $dto['active'] = isset($dto['active']) ? true : false;
        $dto['headquarter_id'] = $dto['company_type'] == 'filial' ? $dto['headquarter_id'] : null;

        $company = Company::findOrFail($id);
        $company->update($dto);
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }
}
