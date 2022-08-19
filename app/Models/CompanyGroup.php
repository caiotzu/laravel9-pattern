<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGroup extends Model {
  public function profile() {
    return $this->belongsTo(Profile::class, 'permission_id', 'id');
  }

  public function roles() {
    return $this->hasMany(Role::class, 'company_group_id', 'id');
  }

  public function companyGroupSettings() {
    return $this->hasMany(CompanyGroupSetting::class, 'company_group_id', 'id');
  }

  public function companies() {
    return $this->hasMany(Company::class, 'company_group_id', 'id');
  }
}
