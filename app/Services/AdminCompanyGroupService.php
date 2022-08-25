<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\CompanyGroup;
use App\Models\AdminSetting;


class AdminCompanyGroupService {
  public function listAllCompanyGroupsWithPagination(): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;
    return CompanyGroup::with('profile')->paginate($recordPerPage);
  }

  public function getCompanyGroupById(Int $id): CompanyGroup {
    return CompanyGroup::findOrFail($id);
  }

  public function createCompanyGroup(Array $dto): CompanyGroup {
    return CompanyGroup::create($dto);
  }

  public function updateCompanyGroup(Int $id, Array $dto): CompanyGroup {
    $companyGroup = CompanyGroup::findOrFail($id);
    $companyGroup->update($dto);
    return $companyGroup;
  }
}
