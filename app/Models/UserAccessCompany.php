<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccessCompany extends Model {
  public function company() {
    return $this->belongsTo(Company::class, 'company_id', 'id');
  }

  public function User() {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
