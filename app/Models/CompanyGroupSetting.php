<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGroupSetting extends Model {
  public function companyGroup() {
    return $this->belongsTo(CompanyGroup::class, 'company_group_id', 'id');
  }
}
