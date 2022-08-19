<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {
  public function companyGroup() {
    return $this->belongsTo(CompanyGroup::class, 'company_group_id', 'id');
  }

  public function companyAddresses() {
    return $this->hasMany(CompanyAddress::class, 'company_id', 'id');
  }

  public function userAccessCompanies() {
    return $this->hasMany(UserAccessCompany::class, 'company_id', 'id');
  }

  public function companyContacts() {
    return $this->hasMany(CompanyContact::class, 'company_id', 'id');
  }
}
