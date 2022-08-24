<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use App\Models\AdminRole;

class AdminRoleService {
  public function listAllAdminRoles(): Collection {
    return AdminRole::get();
  }

  public function listAllAdminRolesWithPagination(): LengthAwarePaginator {
    return AdminRole::paginate(10);
  }
}
