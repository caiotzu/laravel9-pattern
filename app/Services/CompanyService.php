<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Company;

class CompanyService {
  public function listAllCompaniesInTheGroup(): Collection {
    $companyGroupId = Auth::guard('web')->user()->role->company->companyGroup->id;
    return Company::where('company_group_id', $companyGroupId)->get();
  }
}
