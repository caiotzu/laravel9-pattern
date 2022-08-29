<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Company;
use App\Models\AdminSetting;

class AdminCompanyService {
  public function listAllCompanies(): Collection {
    return Company::get();
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
}
