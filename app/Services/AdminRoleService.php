<?php

namespace App\Services;

use App\Models\AdminRole;

class AdminRoleService {
  public function listAllAdminRoles() {
    return AdminRole::get();
  }
}
