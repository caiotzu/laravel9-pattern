<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
  public function companyGroup() {
    return $this->belongsTo(CompanyGroup::class, 'company_group_id', 'id');
  }

  public function users() {
    return $this->hasMany(User::class, 'role_id', 'id');
  }

  public function RolePermissions() {
    return $this->hasMany(RolePermission::class, 'role_id', 'id');
  }
}
