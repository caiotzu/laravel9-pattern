<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model {
  public function company() {
    return $this->belongsTo(Company::class, 'company_id', 'id');
  }
}
