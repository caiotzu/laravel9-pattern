<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Company;
use App\Models\AdminSetting;

class AdminCompanyService {
  public function listAllCompaniesWithPagination(): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;
    return Company::with('companyGroup.profile')->paginate($recordPerPage);
  }
}
