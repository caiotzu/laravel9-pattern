<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGroup extends Model {
  public function profile() {
    return $this->belongsTo(Profile::class, 'profile_id', 'id');
  }
}
