<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model {

  public function users() {
    return $this->hasMany(AdminUser::class, 'role_id', 'id');
  }

  public function rolePermissions() {
    return $this->hasMany(AdminRolePermission::class, 'role_id', 'id');
  }
}
